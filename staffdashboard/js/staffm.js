// Staff Management System
class StaffManagement {
    constructor() {
        this.staff = JSON.parse(localStorage.getItem('staff')) || [];
        this.assignedStaff = JSON.parse(localStorage.getItem('assignedStaff')) || [];
        this.attendance = JSON.parse(localStorage.getItem('attendance')) || {};
        this.performance = JSON.parse(localStorage.getItem('performance')) || {};
        
        this.initializeEventListeners();
        this.updateTables();
    }

    initializeEventListeners() {
        // Add Staff Form
        document.getElementById('addStaffForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.addStaff();
        });

        // Search functionality
        const searchInput = document.getElementById('staffSearch');
        const roleFilter = document.getElementById('roleFilter');
        
        if (searchInput) {
            // Search on input change
            searchInput.addEventListener('input', () => this.handleSearch());
            
            // Search on Enter key
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.handleSearch();
                }
            });
        }
        
        if (roleFilter) {
            roleFilter.addEventListener('change', () => this.handleSearch());
        }

        // Confirmation dialog buttons
        document.getElementById('confirmRemove').addEventListener('click', () => {
            this.removeStaff(this.staffToRemove);
            this.hideConfirmationDialog();
        });

        document.getElementById('cancelRemove').addEventListener('click', () => {
            this.hideConfirmationDialog();
        });
    }

    handleSearch() {
        const searchTerm = document.getElementById('staffSearch').value.toLowerCase();
        const roleFilter = document.getElementById('roleFilter').value;
        
        let filteredStaff = this.staff.filter(staff => {
            const nameMatch = staff.name.toLowerCase().startsWith(searchTerm);
            const roleMatch = roleFilter === 'all' || staff.role === roleFilter;
            return nameMatch && roleMatch;
        });

        this.updateSearchResults(filteredStaff);
        
        // Show feedback message
        this.showSearchFeedback(filteredStaff.length, searchTerm, roleFilter);
    }

    showSearchFeedback(count, searchTerm, roleFilter) {
        const searchResultsBody = document.querySelector('#searchResults tbody');
        if (!searchResultsBody) return;

        // Clear previous feedback if any
        const existingFeedback = document.querySelector('.search-feedback');
        if (existingFeedback) {
            existingFeedback.remove();
        }

        // Create feedback message
        const feedback = document.createElement('div');
        feedback.className = 'search-feedback';
        
        if (count === 0) {
            feedback.innerHTML = `No staff members found with name starting with "${searchTerm}"${roleFilter !== 'all' ? ` in role "${roleFilter}"` : ''}`;
        } else {
            feedback.innerHTML = `Found ${count} staff member${count > 1 ? 's' : ''} with name starting with "${searchTerm}"${roleFilter !== 'all' ? ` in role "${roleFilter}"` : ''}`;
        }
        
        // Insert feedback before the table
        searchResultsBody.parentNode.insertBefore(feedback, searchResultsBody);
    }

    updateSearchResults(filteredStaff) {
        const searchResultsBody = document.querySelector('#searchResults tbody');
        if (!searchResultsBody) return;

        searchResultsBody.innerHTML = '';
        
        if (filteredStaff.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = '<td colspan="4" style="text-align: center;">No staff members found</td>';
            searchResultsBody.appendChild(row);
            return;
        }

        filteredStaff.forEach(staff => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${staff.name}</td>
                <td>${staff.role}</td>
                <td>${staff.shift}</td>
                <td>${staff.attendance}%</td>
            `;
            searchResultsBody.appendChild(row);
        });
    }

    addStaff() {
        const name = document.getElementById('staffName').value;
        const email = document.getElementById('staffEmail').value;
        const phone = document.getElementById('staffPhone').value;
        const role = document.getElementById('staffRole').value;
        const shift = document.getElementById('staffShift').value;
        const department = document.getElementById('staffDepartment').value;

        // Validate inputs
        if (!name || !email || !phone || !role || !shift || !department) {
            alert('Please fill in all fields');
            return;
        }

        // Create new staff member
        const newStaff = {
            id: this.staff.length + 1,
            name,
            email,
            phone,
            role,
            shift,
            department
        };

        this.staff.push(newStaff);
        localStorage.setItem('staff', JSON.stringify(this.staff));

        // Reset form
        document.getElementById('addStaffForm').reset();
        this.updateTables();
    }

    assignStaffToFlight(staffId, flightId) {
        const staffMember = this.staff.find(s => s.id === staffId);
        if (staffMember) {
            staffMember.isAssigned = true;
            this.assignedStaff.push({
                staffId,
                flightId,
                assignmentDate: new Date().toISOString()
            });
            this.saveToLocalStorage();
            this.updateTables();
        }
    }

    updateAttendance(staffId, isPresent) {
        const staffMember = this.staff.find(s => s.id === staffId);
        if (staffMember) {
            if (!this.attendance[staffId]) {
                this.attendance[staffId] = { present: 0, total: 0 };
            }
            this.attendance[staffId].total++;
            if (isPresent) {
                this.attendance[staffId].present++;
            }
            staffMember.attendance = Math.round((this.attendance[staffId].present / this.attendance[staffId].total) * 100);
            this.saveToLocalStorage();
            this.updateTables();
        }
    }

    updatePerformance(staffId, rating) {
        const staffMember = this.staff.find(s => s.id === staffId);
        if (staffMember) {
            if (!this.performance[staffId]) {
                this.performance[staffId] = { ratings: [] };
            }
            this.performance[staffId].ratings.push(rating);
            staffMember.performance = Math.round(
                this.performance[staffId].ratings.reduce((a, b) => a + b, 0) / 
                this.performance[staffId].ratings.length
            );
            this.saveToLocalStorage();
            this.updateTables();
        }
    }

    saveToLocalStorage() {
        localStorage.setItem('staff', JSON.stringify(this.staff));
        localStorage.setItem('assignedStaff', JSON.stringify(this.assignedStaff));
        localStorage.setItem('attendance', JSON.stringify(this.attendance));
        localStorage.setItem('performance', JSON.stringify(this.performance));
    }

    updateTables() {
        // Update Available Staff Table
        const availableStaffTableBody = document.querySelector('#availableStaffTable tbody');
        availableStaffTableBody.innerHTML = '';
        this.staff.filter(staff => !staff.isAssigned).forEach(staff => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${staff.name}</td>
                <td>${staff.role}</td>
                <td>${staff.shift}</td>
                <td>
                    <button class="delete-btn" onclick="staffManagement.showConfirmationDialog(${staff.id})">Delete</button>
                </td>
            `;
            availableStaffTableBody.appendChild(row);
        });

        // Update Attendance Table
        const attendanceTableBody = document.querySelector('#attendanceTable tbody');
        attendanceTableBody.innerHTML = '';
        this.staff.forEach(staff => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${staff.name}</td>
                <td>${staff.attendance}%</td>
                <td>${staff.performance}/5</td>
            `;
            attendanceTableBody.appendChild(row);
        });
    }

    showConfirmationDialog(staffId) {
        this.staffToRemove = staffId;
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('confirmationDialog').style.display = 'block';
    }

    hideConfirmationDialog() {
        this.staffToRemove = null;
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('confirmationDialog').style.display = 'none';
    }

    removeStaff(staffId) {
        // Remove staff member
        this.staff = this.staff.filter(staff => staff.id !== staffId);
        localStorage.setItem('staff', JSON.stringify(this.staff));

        // Update tables
        this.updateTables();
        this.handleSearch();
    }
}

// Initialize Staff Management System
const staffManagement = new StaffManagement();

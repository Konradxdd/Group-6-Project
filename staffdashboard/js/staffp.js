class StaffProfile {
    constructor() {
        this.staff = JSON.parse(localStorage.getItem('staff')) || [];
        this.currentUser = JSON.parse(localStorage.getItem('currentUser')) || null;
        
        this.initializeEventListeners();
        this.loadCurrentUserProfile();
    }

    initializeEventListeners() {
        // Profile form submission
        document.getElementById('profileForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.updateProfile();
        });

        // Search functionality
        document.getElementById('searchStaffInput').addEventListener('input', (e) => {
            this.searchStaff(e.target.value);
        });

        // Update staff form submission
        document.getElementById('updateStaffForm').addEventListener('submit', (e) => {
            e.preventDefault();
            this.updateStaffDetails();
        });
    }

    loadCurrentUserProfile() {
        // If there's no current user, use the first staff member as default
        if (!this.currentUser && this.staff.length > 0) {
            this.currentUser = this.staff[0];
        }

        if (this.currentUser) {
            const user = this.staff.find(s => s.id === this.currentUser.id);
            if (user) {
                document.getElementById('fullName').value = user.name;
                document.getElementById('email').value = user.email;
                document.getElementById('phone').value = user.phone;
                document.getElementById('department').value = user.department;
                document.getElementById('performanceRating').value = user.performanceRating || '';
                document.getElementById('attendance').value = user.attendance || '';
            }
        }
    }

    updateProfile() {
        const name = document.getElementById('fullName').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const department = document.getElementById('department').value;
        const performanceRating = document.getElementById('performanceRating').value;
        const attendance = document.getElementById('attendance').value;

        // Validate inputs
        if (!name || !email || !phone || !department) {
            alert('Please fill in all required fields');
            return;
        }

        if (performanceRating && (performanceRating < 1 || performanceRating > 5)) {
            alert('Performance rating must be between 1 and 5');
            return;
        }

        if (attendance && (attendance < 0 || attendance > 100)) {
            alert('Attendance percentage must be between 0 and 100');
            return;
        }

        // Update current user's profile
        const userIndex = this.staff.findIndex(s => s.id === this.currentUser.id);
        if (userIndex !== -1) {
            this.staff[userIndex] = {
                ...this.staff[userIndex],
                name,
                email,
                phone,
                department,
                performanceRating: performanceRating ? parseInt(performanceRating) : null,
                attendance: attendance ? parseInt(attendance) : null
            };

            localStorage.setItem('staff', JSON.stringify(this.staff));
            alert('Profile updated successfully');
        }
    }

    searchStaff(query) {
        const searchResultsTable = document.getElementById('searchResultsTable').getElementsByTagName('tbody')[0];
        searchResultsTable.innerHTML = '';

        if (!query) return;

        const results = this.staff.filter(staff => 
            staff.name.toLowerCase().startsWith(query.toLowerCase())
        );

        results.forEach(staff => {
            const row = searchResultsTable.insertRow();
            row.innerHTML = `
                <td>${staff.name}</td>
                <td>${staff.email}</td>
                <td>${staff.phone}</td>
                <td>${staff.department}</td>
                <td>${staff.performanceRating || '-'}</td>
                <td>${staff.attendance || '-'}%</td>
                <td>
                    <button onclick="staffProfile.editStaff(${staff.id})">Edit</button>
                </td>
            `;
        });
    }

    editStaff(staffId) {
        const staff = this.staff.find(s => s.id === staffId);
        if (!staff) return;

        // Show update form
        document.querySelector('.update-staff-section').style.display = 'block';
        
        // Populate form
        document.getElementById('updateStaffId').value = staffId;
        document.getElementById('updateFullName').value = staff.name;
        document.getElementById('updateEmail').value = staff.email;
        document.getElementById('updatePhone').value = staff.phone;
        document.getElementById('updateDepartment').value = staff.department;
        document.getElementById('updatePerformanceRating').value = staff.performanceRating || '';
        document.getElementById('updateAttendance').value = staff.attendance || '';
    }

    updateStaffDetails() {
        const staffId = parseInt(document.getElementById('updateStaffId').value);
        const name = document.getElementById('updateFullName').value;
        const email = document.getElementById('updateEmail').value;
        const phone = document.getElementById('updatePhone').value;
        const department = document.getElementById('updateDepartment').value;
        const performanceRating = document.getElementById('updatePerformanceRating').value;
        const attendance = document.getElementById('updateAttendance').value;

        // Validate inputs
        if (!name || !email || !phone || !department) {
            alert('Please fill in all required fields');
            return;
        }

        if (performanceRating && (performanceRating < 1 || performanceRating > 5)) {
            alert('Performance rating must be between 1 and 5');
            return;
        }

        if (attendance && (attendance < 0 || attendance > 100)) {
            alert('Attendance percentage must be between 0 and 100');
            return;
        }

        // Update staff details
        const staffIndex = this.staff.findIndex(s => s.id === staffId);
        if (staffIndex !== -1) {
            this.staff[staffIndex] = {
                ...this.staff[staffIndex],
                name,
                email,
                phone,
                department,
                performanceRating: performanceRating ? parseInt(performanceRating) : null,
                attendance: attendance ? parseInt(attendance) : null
            };

            localStorage.setItem('staff', JSON.stringify(this.staff));
            alert('Staff details updated successfully');
            
            // Hide update form and refresh search results
            document.querySelector('.update-staff-section').style.display = 'none';
            this.searchStaff(document.getElementById('searchStaffInput').value);
        }
    }
}

// Initialize staff profile management
const staffProfile = new StaffProfile(); 
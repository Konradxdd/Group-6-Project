document.addEventListener("DOMContentLoaded", function() {
    console.log("Staff Profile Loaded");
  
    // Get references to the form and its fields
    const profileForm = document.getElementById("profileForm");
    const staffIdField = document.getElementById("staffId");
    const staffNameField = document.getElementById("staffName");
    const staffEmailField = document.getElementById("staffEmail");
    const staffPhoneField = document.getElementById("staffPhone");
    const staffRoleField = document.getElementById("staffRole");
    const staffShiftField = document.getElementById("staffShift");
    const staffDepartmentField = document.getElementById("staffDepartment");
    const staffPerformanceField = document.getElementById("staffPerformance");
    const staffAttendanceField = document.getElementById("staffAttendance");
    
    // Handle profile form submission (update or create record)
    profileForm.addEventListener("submit", function(event) {
      event.preventDefault();
      
      const idValue = staffIdField.value;
      const name = staffNameField.value.trim();
      const email = staffEmailField.value.trim();
      const phone = staffPhoneField.value.trim();
      const role = staffRoleField.value;
      const shift = staffShiftField.value;
      const department = staffDepartmentField.value.trim();
      const performance = parseInt(staffPerformanceField.value, 10);
      const attendance = parseInt(staffAttendanceField.value, 10);
    
      if (name === "" || email === "") {
        alert("Name and Email cannot be empty.");
        return;
      }
    
      let staffData = JSON.parse(localStorage.getItem("staff")) || [];
    
      if (idValue) {
        // Update existing staff record
        staffData = staffData.map(staff => {
          if (Number(staff.id) === Number(idValue)) {
            return {
              ...staff,
              name,
              email,
              phone,
              role,
              shift,
              department,
              performance,
              attendance
            };
          }
          return staff;
        });
        alert("Staff profile updated successfully!");
      } else {
        // Create new staff record if no ID exists
        const newStaff = {
          id: Date.now(),
          name,
          email,
          phone,
          role,
          shift,
          department,
          performance,
          attendance
        };
        staffData.push(newStaff);
        alert("New staff profile created successfully!");
      }
    
      localStorage.setItem("staff", JSON.stringify(staffData));
      // Clear hidden id after saving
      staffIdField.value = "";
      // Optionally, clear the form or leave it filled
      // profileForm.reset();
      // Refresh search results if applicable
      performStaffSearch(searchInput.value);
    });
    
    // Search functionality
    const searchInput = document.getElementById("searchStaffInput");
    const searchResultsTableBody = document.querySelector("#searchResultsTable tbody");
    
    searchInput.addEventListener("input", function() {
      performStaffSearch(searchInput.value);
    });
    
    function performStaffSearch(query) {
      const staffData = JSON.parse(localStorage.getItem("staff")) || [];
      const lowerQuery = query.toLowerCase();
      const filteredStaff = staffData.filter(staff => staff.name.toLowerCase().includes(lowerQuery));
      renderSearchResults(filteredStaff);
    }
    
    function renderSearchResults(filteredStaff) {
      searchResultsTableBody.innerHTML = "";
      if (filteredStaff.length === 0) {
        const row = document.createElement("tr");
        row.innerHTML = `<td colspan="7" style="text-align: center;">No staff found</td>`;
        searchResultsTableBody.appendChild(row);
        return;
      }
      filteredStaff.forEach(function(staff) {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${staff.name}</td>
          <td>${staff.email || ""}</td>
          <td>${staff.phone || ""}</td>
          <td>${staff.department || ""}</td>
          <td>${staff.performance || "N/A"}</td>
          <td>${staff.attendance || "N/A"}</td>
          <td><button data-id="${staff.id}" class="editStaffBtn">Edit</button></td>
        `;
        searchResultsTableBody.appendChild(row);
      });
    
      // Attach event listeners to edit buttons
      document.querySelectorAll(".editStaffBtn").forEach(function(btn) {
        btn.addEventListener("click", function() {
          const staffId = btn.getAttribute("data-id");
          console.log("Edit button clicked for staff ID:", staffId);
          loadStaffDetailsForEdit(staffId);
        });
      });
    }
    
    // Auto-fill the update profile form with selected staff details
    function loadStaffDetailsForEdit(staffId) {
      const staffData = JSON.parse(localStorage.getItem("staff")) || [];
      const staff = staffData.find(s => Number(s.id) === Number(staffId));
      console.log("Attempting to load details for staff:", staff);
      if (staff) {
        staffIdField.value = staff.id;
        staffNameField.value = staff.name || "";
        staffEmailField.value = staff.email || "";
        staffPhoneField.value = staff.phone || "";
        staffRoleField.value = staff.role || "Pilot";
        staffShiftField.value = staff.shift || "Morning";
        staffDepartmentField.value = staff.department || "";
        staffPerformanceField.value = staff.performance || "";
        staffAttendanceField.value = staff.attendance || "";
        // Scroll the update form into view
        profileForm.scrollIntoView({ behavior: "smooth" });
      } else {
        console.log("No matching staff found for id:", staffId);
      }
    }
  });
  
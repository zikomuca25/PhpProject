<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard</title>
    
    <!-- Bootstrap & DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />

    <!-- jQuery, DataTables, Chart.js & FontAwesome -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script type="module" src="app.js"></script>
    <script type="module" src="bootstrap.js"></script>
    
  </head>
  <body>
    
    <style>
      

.chat-user-container {
    margin-top: 10px;
}

.chat-users {
    display: none; /* Initially hidden */
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px;
    margin-top: 5px;
    max-height: 200px; /* Set a max height */
    overflow-y: auto; /* Enable scrolling */
}

.chat-users ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.chat-users li {
    padding: 8px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
}

.chat-users li:hover {
    background: #f1f1f1;
}

  .chat-container {
    width: 300px;
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    display: none;
    flex-direction: column;
    border: 1px solid #ccc;
}

.chat-header {
    background: #6a5acd;
    color: white;
    padding: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 10px 10px 0 0;
}

.chat-messages {
    height: 250px;
    overflow-y: auto;
    padding: 10px;
}

.chat-input {
    display: flex;
    padding: 10px;
    border-top: 1px solid #ccc;
}

.chat-input input {
    flex: 1;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.send-btn {
    background: #6a5acd;
    color: white;
    border: none;
    padding: 5px 10px;
    margin-left: 5px;
    cursor: pointer;
}

.close-btn {
    background: transparent;
    color: white;
    border: none;
    font-size: 18px;
    cursor: pointer;
}


      body {
        background-color: #f8f9fa;
      }
      .top-bar {
        background-color: #6a5acd;
        color: white;
        padding: 15px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      }
      .sidebar {
        width: 260px;
        background-color: #574b90;
        color: white;
        padding: 20px;
        height: 100vh;
        position: fixed;
        top: 60px;
        left: 0;
        overflow-y: auto;
        box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1);
      }
      .sidebar h5 {
        margin-bottom: 15px;
        text-align: center;
        font-weight: bold;
      }
      .profile-container {
        background: #7b68ee;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        text-align: center;
      }
      .profile-container img {
        border: 3px solid white;
        margin-bottom: 10px;
      }
      .profile-container p {
        margin: 5px 0;
      }
      .btn-primary, .btn-secondary {
        border-radius: 5px;
        font-weight: bold;
      }
      .btn-secondary {
        background-color: #444;
        border: none;
      }
      .container-content {
        margin-left: 280px;
        margin-top: 80px;
        padding: 20px;
      }
      .tree-container, .employee-container {
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      }
      .tree-container h5, .employee-container h5 {
        border-bottom: 2px solid #7b68ee;
        padding-bottom: 10px;
        margin-bottom: 15px;
        font-weight: bold;
      }
      .tree-container {
        height: auto;
        overflow-y: auto;
      }
      .dataTables_wrapper {
        padding: 10px;
      }
    
    </style>
  <div class="top-bar d-flex justify-content-between align-items-center p-3 bg-dark text-white">
    <span>{{ Auth::user()->role  ?? Auth::user()->role  }} Dashboard</span>

    <div class="icon-container d-flex align-items-center">
        <span>Welcome, {{ Auth::user()->username ?? 'Guest' }}</span>

        <i class="fa-solid fa-comments mx-3" title="Chat"> </i>

  <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button class="btn btn-outline-light ms-3">🚪 Logout</button>
        </form> 
        
      
    </div>
  
</div>

</div>


    <div class="sidebar">
      <h5>---------------</h5>
      <div class="profile-container">
        <h5>Welcome, Admin</h5>
        <img src="{{ Auth::user()->admin->profile_picture ? asset('storage/' .Auth::user()->admin->profile_picture) : asset('default-profile.png') }}" 
        class="img-fluid rounded-circle" width="80" />        <h1>User Profile</h1>
    <p><strong>Name:</strong> {{ Auth::user()->admin->first_name ?? 'N/A' }}</p>
    <p><strong>Surname:</strong> {{ Auth::user()->admin->last_name ?? 'N/A' }}</p>
    <p><strong>Department:</strong> {{ Auth::user()->admin->department->name ?? 'N/A' }}</p>
    <p><strong>Address:</strong> {{ Auth::user()->admin->address ?? 'N/A' }}</p>
    <p><strong>Phone:</strong> {{ Auth::user()->admin->phone ?? 'N/A' }}</p>
    <p><strong>Role:</strong> {{ Auth::user()->role }}</p>
    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
      </div>
      <button class="btn btn-primary w-100" id="addDepartmentBtn">Add Department</button>
      <button class="btn btn-secondary w-100 mt-2" id="addEmployeeBtn">Add Employee</button>
    </div>

    <div class="container-content">
      <div class="row">
        <div class="col-md-6">
          <div class="tree-container">
            <h5>Departments</h5>
            <ul id="departmentTree"></ul>
          </div>
        </div>
        <div class="col-md-6">
          <div class="employee-container">
            <h5>Employees</h5>
            <table id="employeesTable" class="display" style="width: 100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Department</th>
                  <th>Actions</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>


       
<!-- User List Modal -->
<div id="userListModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select a User to Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul id="userList" class="list-group">
                    <!-- Users  -->
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Chat Box -->
<div id="chatBox" class="chat-container" style="display: none;">
    <div class="chat-header">
        <span id="chatUser">Chat</span>
        <button id="closeChat" class="close-btn">&times;</button>
    </div>

    <div id="chatMessages" class="chat-messages">
        <!-- Messages  -->
    </div>

    <div class="chat-input">
        <input type="text" id="chatMessage" placeholder="Type a message..." autocomplete="off">
        <button id="sendChat" class="send-btn">Send</button>
    </div>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="departmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="departmentForm">
                    <input type="hidden" id="department_id">
                    
                    <div class="mb-3">
                        <label>Department Name</label>
                        <input type="text" id="department_name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <input type="checkbox" id="is_subdepartment">
                        <label for="is_subdepartment">Is Subdepartment?</label>
                    </div>
                    
                    <div class="mb-3" id="parent_department_container" style="display: none;">
                        <label>Parent Department</label>
                        <select id="parent_department" class="form-control">
                            <!-- Options  -->
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editEmployeeForm" enctype="multipart/form-data">
                    <input type="hidden" id="edit_employee_id">
                    
                    <!-- User Fields -->
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" id="edit_username" name="username" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="edit_email" name="email" class="form-control" required>
                    </div>
                    
                    
                    
                    <!-- Employee Fields -->
                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" id="edit_first_name" name="first_name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" id="edit_last_name" name="last_name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Department</label>
                        <select id="edit_department_id" name="department_id" class="form-control" required>
                            <!-- Options -->
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" id="edit_phone" name="phone" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label>Address</label>
                        <input type="text" id="edit_address" name="address" class="form-control">
                    </div>
                    
                    <div class="mb-3 text-center">
    <label>Current Profile Picture</label>
    <br>


    <img id="edit_profile_picture_preview" src="{{ asset($user->profile_picture ?? 'storage/images/default-profile.png') }}" class="img-fluid rounded" width="100" style="display: none;">
</div>

<div class="mb-3">
    <label>Change Profile Picture</label>
    <input type="file" id="edit_profile_picture" name="profile_picture" class="form-control">
</div>

                    
                    <button type="submit" class="btn btn-primary">Update Employee</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm" enctype="multipart/form-data">
                    <input type="hidden" id="add_employee_id">
                    
                    <!-- User Fields -->
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" id="add_username" name="username" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="add_email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" id="add_password" name="password" class="form-control" required>
                    </div>
                    
                    
                    
                    <!-- Employee Fields -->
                    <div class="mb-3">
                        <label>First Name</label>
                        <input type="text" id="add_first_name" name="first_name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Last Name</label>
                        <input type="text" id="add_last_name" name="last_name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Department</label>

                        <select id="add_department_id" name="department_id" class="form-control" required>
                            <!-- Options will be loaded dynamically -->
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" id="add_phone" name="phone" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label>Address</label>
                        <input type="text" id="add_address" name="address" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label>Profile Picture</label>
                        <input type="file" id="add_profile_picture" name="profile_picture" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!--skripti per addEmployee-->
<script>
$(document).ready(function () {
    // Open modal when Add Employee button is clicked
    $('#addEmployeeBtn').click(function () {
        $('#addEmployeeModal').modal('show');
        loadAddDepartmentsDropdown(); 
    });

    // Handle form submission
    $('#addEmployeeForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $.ajax({
            url: '/admin/add-employee',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response.message);
                $('#addEmployeeModal').modal('hide');
                $('#addEmployeeForm')[0].reset();
                loadEmployeesTable(); // Refresh employees list
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
                alert('Failed to add employee.');
            }
        });
    });
});
function loadAddDepartmentsDropdown() {
    $.ajax({
        url: '/admin/get-departments',
        type: 'GET',
        success: function (response) {
            let dropdown = $('#add_department_id');
            dropdown.empty().append('<option value="">Select Department</option>');
            response.forEach(dept => {
                dropdown.append(`<option value="${dept.id}">${dept.name}</option>`);
            });
        },
        error: function () {
            console.error('Failed to load departments.');
        }
    });
}
</script>
    <!--skripti per addDepartment-->

<script>
  
  $(document).ready(function () {
    $('#addDepartmentBtn').click(function () {
        $('#departmentModal').modal('show');
    });
});

$(document).ready(function () {

    // Load departments into the dropdown when modal is opened
    $('#departmentModal').on('show.bs.modal', function () {
        loadDepartmentsDropdown();
    });

    // Toggle parent department dropdown visibility
    $('#is_subdepartment').change(function () {
        if ($(this).is(':checked')) {
            $('#parent_department_container').show();
        } else {
            $('#parent_department_container').hide();
        }
    });

    // Handle form submission
    $('#departmentForm').submit(function (e) {
        e.preventDefault();
        let departmentName = $('#department_name').val().trim();
        let isSubdepartment = $('#is_subdepartment').is(':checked');
        let parentDepartment = isSubdepartment ? $('#parent_department option:selected').val() : 1;
        console.log("Selected Parent Department ID:", parentDepartment); // Debugging


        $.ajax({
            url: '/admin/add-department',
            type: 'POST',
            data: {
                name: departmentName,
                parent_id: parentDepartment,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                alert(response.message);
                $('#departmentModal').modal('hide');
                $('#departmentForm')[0].reset();
                loadDepartmentsDropdown(); 
                loadDepartmentTree();

            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
                alert('Failed to add department.');
            }
        });
    });
});

// Load existing departments into dropdown
function loadDepartmentsDropdown() {
    $.ajax({
        url: '/admin/get-departments',
        type: 'GET',
        success: function (response) {
            let dropdown = $('#parent_department');
            dropdown.empty().append('<option value="1">Main Department</option>');
            response.forEach(dept => {
                dropdown.append(`<option value="${dept.id}">${dept.name}</option>`);
            });
        },
        error: function () {
            console.error('Failed to load departments.');
        }
    });
}
</script>
    <!--skripti per UserTeChat-->

<script>
$(document).ready(function () {
    let recipientId = null; // Store the selected user's ID
    setInterval(fetchUsers, 5000); // Refresh user list every 5 seconds

    // Open user selection modal when clicking chat icon
    $(".fa-comments").click(function () {
        fetchUsers(); // Load users
        $("#userListModal").modal("show"); // Show modal
    });

    // Function to fetch users
    function fetchUsers() {
    $.ajax({
        url: "/admin/get-users",
        type: "GET",
        success: function (response) {
            let userList = $("#userList");
            userList.empty();

            response.forEach(user => {
                let unreadBadge = user.unread_count > 0 ? `<span class="badge bg-danger ms-2">${user.unread_count}</span>` : "";
                userList.append(`
                    <li class="list-group-item user-item d-flex justify-content-between align-items-center" data-id="${user.id}">
                        ${user.username} ${unreadBadge}
                    </li>
                `);
            });
        },
        error: function () {
            console.error("Failed to fetch users.");
        }
    });
}

$("#closeChat").click(function () {
    $("#chatBox").fadeOut(); // Close the chatbox
});

    // Select user and open chat window
    $(document).on("click", ".user-item", function () {
        recipientId = $(this).data("id"); // Set recipient ID
        $("#userListModal").modal("hide"); // Close user selection modal
        $("#chatBox").fadeIn(); // Show chatbox
        $("#chatUser").text($(this).text()); // Show selected username
        
        loadMessages(); // Load chat history
        markMessagesAsRead();

    });

    // Send message when clicking the send button
    $("#sendChat").click(function () {
        sendMessage();
    });

    // Allow Enter key to send message
    $("#chatMessage").keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Function to send message
    function sendMessage() {
        let message = $("#chatMessage").val().trim();
        if (!message || !recipientId) {
            alert("Select a user first!");
            return;
        }

        $.ajax({
            url: "/admin/send-message",
            type: "POST",
            data: {
                recipient_id: recipientId,
                message: message,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $("#chatMessage").val(""); // Clear input field
                loadMessages(); // Refresh messages after sending
            },
            error: function () {
                alert("Message failed to send.");
            }
        });
    }
    function markMessagesAsRead() {
    if (!recipientId) return;

    $.ajax({
        url: "/admin/mark-messages-read",
        type: "POST",
        data: {
            sender_id: recipientId,
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF Token
        },
        success: function () {
            fetchUsers(); // Refresh the user list to remove unread count
        },
        error: function () {
            console.error("Failed to mark messages as read.");
        }
    });
}

    // Function to fetch messages for selected user
    function loadMessages() {
        if (!recipientId) return;

        $.ajax({
            url: "/admin/get-messages",
            type: "GET",
            data: { recipient_id: recipientId },
            success: function (response) {
                let chatMessages = $("#chatMessages");
                chatMessages.html("");

                response.forEach(msg => {
                    let alignment = (msg.sender_id === {{ Auth::id() }}) ? "text-end" : "text-start";
                    chatMessages.append(`<div class="${alignment}"><b>${msg.message}</b></div>`);
                });

                chatMessages.scrollTop(chatMessages[0].scrollHeight);
            },
            error: function () {
                console.error("Failed to fetch messages.");
            }
        });
    }
});



</script>
    <!--skripti per EmployeeTree and DepartmentTree-->

    <script>
$(document).ready(function () {
  loadDepartmentTree()
    loadEmployeesTable(); // Load all employees initially

    // Handle department click
    $(document).on("click", ".department-item", function (event) {
        event.stopPropagation(); // Prevents click from bubbling up
        let departmentId = $(this).attr("data-id");
        console.log("Clicked Department ID:", departmentId);

        if (departmentId) {
            loadEmployeesTable(departmentId); // Filter employees
        }
    });

    $(document).on("click", ".sidebar", function () {
        console.log("Sidebar clicked - Resetting table");
        loadEmployeesTable(); // Reload all employees
    });
});


/**
 * Function to Load Department Tree (HTML Response)
 */
function loadDepartmentTree() {
    $.ajax({
        url: "{{ route('admin.getDepartmentsTree') }}",
        method: "GET",
        dataType: "html",
        success: function (html) {
            $('#departmentTree').html(html);
            
            // Ensure departments are clickable by adding a class and data-id
            $("#departmentTree li").each(function () {
                let deptId = $(this).attr("data-id");
                $(this).addClass("department-item").attr("data-id", deptId);
            });
        },
        error: function () {
            $('#departmentTree').html('<p class="text-danger">Failed to load departments.</p>');
        }
    });
}

/**
 * Function to Load Employees Table (DataTables with AJAX, with optional department filtering)
 */
function loadEmployeesTable(departmentId = null) {
    let table = $('#employeesTable').DataTable();
    if ($.fn.DataTable.isDataTable('#employeesTable')) {
        table.destroy();
    }
    
    $('#employeesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.getEmployees') }}",
            data: { department_id: departmentId },
        },
        columns: [
            { data: "id" },
            { data: "name" },
            { data: "department" },
            { data: "actions", orderable: false }
        ],
    });
}



/**
 * Handle Employee Deletion
 */
$(document).on('click', '.delete-employee', function () {
    let employeeId = $(this).data('id');

    if (confirm("Are you sure you want to delete this employee?")) {
        $.ajax({
            url: `/admin/delete-employee/${employeeId}`,
            method: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                alert(response.message);
                $('#employeesTable').DataTable().ajax.reload();
            },
            error: function (xhr) {
                console.error("Delete Error:", xhr.responseText);
                alert("Failed to delete employee.");
            }
        });
    }
});

    </script>
<script>
$(document).ready(function () {
    // Handle Edit Button Click
    $(document).on("click", ".edit-employee", function () {
        let employeeId = $(this).data("id");
        console.log("Selected Employee ID:", employeeId);

        $.ajax({
            url: `/admin/get-employee/${employeeId}`,
            type: "GET",
            success: function (response) {
                console.log("Employee Data:", response);

                // Populate form fields
                $("#edit_employee_id").val(response.id);
                $("#edit_username").val(response.user.username);
                $("#edit_email").val(response.user.email);
                $("#edit_first_name").val(response.first_name);
                $("#edit_last_name").val(response.last_name);
                $("#edit_phone").val(response.phone);
                $("#edit_address").val(response.address);

                // Handle profile picture preview
                if (response.profile_picture) {
                    $("#edit_profile_picture_preview").attr("src", `/storage/${response.profile_picture}`).show();
                } else {
                    $("#edit_profile_picture_preview").attr("src", "/images/default-profile.png").show();
                }

                // Load departments and pre-select the existing department
                loadEditDepartmentsDropdown(response.department_id);

                // Show the modal
                $("#editEmployeeModal").modal("show");
            },
            error: function () {
                alert("Failed to fetch employee details.");
            }
        });
    });

    // Handle Edit Form Submission
    $("#editEmployeeForm").submit(function (e) {
        e.preventDefault(); // Prevent default form submission
        
        let formData = new FormData(this);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
        let employeeId = $("#edit_employee_id").val();

        $.ajax({
            url: `/admin/update-employee/${employeeId}`, // API endpoint to update employee
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response.message);
                $("#editEmployeeModal").modal("hide"); // Hide modal after update
                $("#editEmployeeForm")[0].reset();
                $("#employeesTable").DataTable().ajax.reload(); // Refresh table
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
                alert("Failed to update employee.");
            }
        });
    });
});

// Function to Load Departments in the Dropdown
function loadEditDepartmentsDropdown(selectedDepartmentId) {
    $.ajax({
        url: '/admin/get-departments',
        type: 'GET',
        success: function (response) {
            let dropdown = $('#edit_department_id');
            
            // Check if the dropdown exists
            if (dropdown.length === 0) {
                console.error('Dropdown element not found: #edit_department_id');
                return;
            }

            dropdown.empty().append('<option value="">Select Department</option>');
            response.forEach(dept => {
                let selected = dept.id == selectedDepartmentId ? 'selected' : '';
                dropdown.append(`<option value="${dept.id}" ${selected}>${dept.name}</option>`);
            });
        },
        error: function () {
            console.error('Failed to load departments.');
        }
    });
}

</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function() {
        history.pushState(null, null, location.href);
        window.onpopstate = function(event) {
            history.pushState(null, null, location.href);
        };
    })();
</script>
  </body>
</html>

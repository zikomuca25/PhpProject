<!DOCTYPE html> 
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Employee Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    
    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
      body { background-color: #f8f9fa; }
      .top-bar {
        background-color: #343a40;
        color: white;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      }
      .sidebar {
        background-color: #0056b3;
        color: white;
        padding: 20px;
        min-height: 100vh;
      }
      .profile-container {
        background: #0066cc;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
      }
      .widget {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
      }
      .btn-custom {
        font-weight: bold;
        padding: 10px;
      }
      .table-responsive {
        padding: 10px;
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
    background: #0056b3;
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
    background: #0056b3;
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

    </style>
  </head>
  <body>
    <!-- User List Modal -->
<div id="userListModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select a User to Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul id="userList" class="list-group"></ul>
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
    <div id="chatMessages" class="chat-messages"></div>
    <div class="chat-input">
        <input type="text" id="chatMessage" placeholder="Type a message...">
        <button id="sendChat" class="send-btn">Send</button>
    </div>
</div>

    <div class="top-bar d-flex justify-content-between align-items-center p-3 bg-dark text-white">
      <span>{{ Auth::user()->role ?? Auth::user()->role }} Dashboard</span>
      <div class="icon-container d-flex align-items-center">
        <span>Welcome, {{ Auth::user()->username ?? 'Guest' }}</span>
        <i class="fa-solid fa-comments mx-3 chat-icon" title="Chat"></i>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button class="btn btn-outline-light ms-3">🚪 Logout</button>
        </form> 
      </div>
    </div>

    <div class="container-fluid mt-5">
      <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar">
          <h5>---------------</h5>
          <div class="profile-container">
            <h5>Welcome, Admin</h5>
            <img src="{{ Auth::user()->employee->profile_picture ? asset('storage/' .Auth::user()->employee->profile_picture) : asset('default-profile.png') }}" 
         class="img-fluid rounded-circle" width="80" />
            <h1>User Profile</h1>
            <p><strong>Name:</strong> {{ Auth::user()->employee->first_name ?? 'N/A' }}</p>
            <p><strong>Surname:</strong> {{ Auth::user()->employee->last_name ?? 'N/A' }}</p>
            <p><strong>Department:</strong> {{ Auth::user()->employee->department->name ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ Auth::user()->employee->address ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ Auth::user()->employee->phone ?? 'N/A' }}</p>
            <p><strong>Role:</strong> {{ Auth::user()->role }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
          </div>
          <button class="btn btn-primary w-100" id="updateProfileBtn">Update profile</button>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
          <div class="row mt-4">
            <div class="col-md-6">
              <div class="widget">
                <h5>Company Announcements</h5>
                <ul class="list-group">
                  <li class="list-group-item"><strong>Office Holiday:</strong> March 15</li>
                  <li class="list-group-item"><strong>New Policy:</strong> Work from home updates</li>
                </ul>
              </div>
            </div>
            <div class="col-md-6">
              <div class="widget">
                <h5>Task List</h5>
                <ul class="list-group">
                  <li class="list-group-item">Complete project report - Due: March 10</li>
                  <li class="list-group-item">Update system documentation - Due: March 12</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-12">
              <div class="widget">
                <h5>Employee Directory</h5>
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="table-light">
                      <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>John Doe</td>
                        <td>IT</td>
                        <td>johndoe@example.com</td>
                      </tr>
                      <tr>
                        <td>Jane Smith</td>
                        <td>HR</td>
                        <td>janesmith@example.com</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
<!-- Update Profile Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateProfileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ Auth::user()->employee->first_name ?? '' }}" required>
          </div>
          
          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ Auth::user()->employee->last_name ?? '' }}" required>
          </div>
          
          <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ Auth::user()->employee->phone ?? '' }}">
          </div>
          
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3">{{ Auth::user()->employee->address ?? '' }}</textarea>
          </div>
          
          <div class="mb-3">
            <label for="profile_picture" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById("updateProfileBtn").addEventListener("click", function() {
    var myModal = new bootstrap.Modal(document.getElementById('updateProfileModal'));
    myModal.show();
  });
  
</script>
<script>
$(document).ready(function () {
    let recipientId = null;

    // Open user selection modal
    $('.chat-icon').click(function () {
        fetchUsers();
        $('#userListModal').modal('show');
    });

    // Fetch users for chat
    function fetchUsers() {
        $.ajax({
            url: '/admin/get-users',
            type: 'GET',
            success: function (response) {
                let userList = $('#userList');
                userList.empty();
                response.forEach(user => {
                    userList.append(`<li class="list-group-item user-item" data-id="${user.id}">${user.username}</li>`);
                });
            },
            error: function () {
                console.error('Failed to fetch users.');
            }
        });
    }

    // Select user to chat
    $(document).on('click', '.user-item', function () {
        recipientId = $(this).data('id');
        $('#userListModal').modal('hide');
        $('#chatBox').fadeIn();
        $('#chatUser').text($(this).text());
        loadMessages();
    });

    // Close chat
    $('#closeChat').click(function () {
        $('#chatBox').fadeOut();
    });

    // Send message
    $('#sendChat').click(function () {
        sendMessage();
    });

    $('#chatMessage').keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            sendMessage();
        }
    });

    function sendMessage() {
        let message = $('#chatMessage').val().trim();
        if (!message || !recipientId) return;

        $.ajax({
            url: '/admin/send-message',
            type: 'POST',
            data: {
                recipient_id: recipientId,
                message: message,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $('#chatMessage').val('');
                loadMessages();
            },
            error: function () {
                alert('Message failed to send.');
            }
        });
    }

    function loadMessages() {
        if (!recipientId) return;

        $.ajax({
            url: '/admin/get-messages',
            type: 'GET',
            data: { recipient_id: recipientId },
            success: function (response) {
                let chatMessages = $('#chatMessages');
                chatMessages.html('');
                response.forEach(msg => {
                    let alignment = (msg.sender_id === {{ Auth::id() }}) ? 'text-end' : 'text-start';
                    chatMessages.append(`<div class="${alignment}"><b>${msg.message}</b></div>`);
                });
                chatMessages.scrollTop(chatMessages[0].scrollHeight);
            },
            error: function () {
                console.error('Failed to fetch messages.');
            }
        });
    }
});
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

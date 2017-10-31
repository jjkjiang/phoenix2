$(".make_admin_button").on('click', function(e) {
  let user_id = $(this).attr('data-user-id');
  confirmation = confirm("Are you sure you'd like to make them an admin?");
  if(confirmation) {
    make_admin(user_id);
  }
  e.preventDefault();
});

$(".make_user_button").on('click', function(e) {
  let user_id = $(this).attr('data-user-id');
  confirmation = confirm("Are you sure you'd like to revoke admin rights?");
  if(confirmation) {
    revoke_admin(user_id);
  }
  e.preventDefault();
});

function revoke_admin(user_id) {
    $.post('/admin/users/revoke_admin', {
      user_id: user_id,
    }, function(data, status, xhr) {
      alert(data.msg);
      location.reload();
    }).fail(function(data, status, xhr) {
      if (xhr.status === 420) {
        alert("Error: User is already a user.");
      } else {
        alert("Error: Unable to revoke admin rights.");
      }
      location.reload();
    });
}

function make_admin(user_id) {
    $.post('/admin/users/make_admin', {
      user_id: user_id,
    }, function(data, status, xhr) {
      alert(data.msg);
      location.reload();
    }).fail(function(data, status, xhr) {
      if (xhr.status === 420) {
        alert("Error: User is already an admin.");
      } else {
        alert("Error: Unable to add admin.");
      }
      location.reload();
    });
}

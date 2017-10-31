$(".make_admin_button").on('click', function(e) {
  let user_id = $(this).attr('data-user-id');
  confirmation = confirm("Are you sure you'd like to make them an admin?");
  if(confirmation) {
    make_admin(user_id);
  }
  e.preventDefault();
});

function make_admin(user_id) {
    alert("This user has ID of: " + user_id);
    $.post('/admin/users/make_admin', {
      user_id: user_id,
    }, function(data, status, xhr) {
      
    }).fail(function(data, status, xhr) {
      if (xhr.status === 420) {
        alert("Error: User is already an admin.");
      } else {
        alert("Error: Unable to add admin: " + );
      }
    });
}
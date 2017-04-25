// Start page fresh with no messages showing
$(function() {
  $('.loading').hide();
  $('.error').hide();
  $('.message').hide();
  $('.warning').hide();
});

// Function to process swipe submission
$('.swipe_form').submit(function(event) {
  event.preventDefault();

  var field = $(".card_swipe_input");    
  verify(field.val());
  field.val('');
});

function clearWarnings() {
  $('.loading').hide();
  $('.error').hide();
  $('.message').hide();
  $('.warning').hide();
}

// Main function used to validate input from card-swipe
function verify(dump) {
    
  var error_msg = $('.error');
  var info_msg = $('.message');
  var warning_msg = $('.warning');
  var spinner = $('.loading');
  spinner.show();
    
  if (dump.length < 117) {
    error_msg.text("Error: Invalid swipe. Please try again.");
    error_msg.show();
    spinner.hide();
  } else {
    clearWarnings();
      
    // Extract the name from the card swipe
    var s_name = parse_name(dump);
    if (!s_name) {
      error_msg.text("Error: Invalid swipe. Please try again.");
      error_msg.show();
      spinner.hide();
      return;
    }
    // Extract the sid from the card swipe
    var s_id = parse_id(dump);
    if (!s_id) {
      error_msg.text("Error: Invalid swipe. Please try again.");
      error_msg.show();
      spinner.hide();
      return;
    }
    
    var card_number = parse_card_number(dump);
    if (!card_number) {
      error_msg.text("Error: Invalid card number. Please try again.");
      error_msg.show();
      spinner.hide();
      return;
    }
    
    // Submit the extracted data to the database for checkin
    $.post( "/swiper/submit", { 
        s_id: s_id, 
        s_name: s_name, 
        card_number: card_number 
    }, function(data, status, xhr) {
      if (status === 200) {
        info_msg.text("Thank you for checking in, " + s_name + "!"); 
        info_msg.show();
        setTimeout(function() { 
          info_msg.text("");
          info_msg.hide(); 
        }, 3000); // Hide checkin confirmation after 3 seconds
      } else if (data === 420) {
        var email = window.prompt("Please enter your email address.", "");
        if(email === undefined || email === "") {
          error_msg.text("Error: Unable to check in. Please try again.");
          error_msg.show();
        } else {
          submit_email(s_id, s_name, email, card_number);
        }
      } else if (status === 421) {
        warning_msg.text("You have already checked in, " + s_name + ".");
        warning_msg.show();
        setTimeout(function() { 
          warning_msg.text("");
          warning_msg.hide();
        }, 2000);
      } else {
        error_msg.text("Error: Unable to check in. Please try again.");
        error_msg.show();
      }
      spinner.hide();
    }).fail(function() {
      alert( "Error processing request. Please try again." );
      error_msg.text("Server Error.");
      error_msg.show();
      spinner.hide();
    });
  }
}

function submit_email(s_id, s_name, email, card_number) {
  var error_msg = $('.error');
  var info_msg = $('.message');
  
  $.post( "/swiper/enroll", { 
      s_id: s_id, 
      s_name: s_name, 
      email: email, 
      card_number: card_number 
  }, function(data, status, xhr) {
      info_msg.text("Welcome to ACM, " + s_name + 
                    "!\nThank you for checking in, " + s_name + "!"); 
      info_msg.show();
      setTimeout(function() { 
        info_msg.text("");
        info_msg.hide(); 
      }, 3000); // Hide checkin confirmation after 3 seconds
  }).fail(function() {
    alert( "Error processing request. Please try again." );
    error_msg.text("Server Error.");
    error_msg.show();
  });
}

function parse_name(dump) {
  // Last name is string of text after ^
  var last_name = dump.match(/\^(.*?)\//);
  if(last_name === null 
      || typeof last_name === undefined 
      || last_name.length < 2) {
    return false;
  }
  // First name is string of text after / 
  var first_name = dump.match(/\/([^\s]+)/);
  if(first_name === null 
      || typeof first_name === undefined 
      || first_name.lengh < 2) {
    return false;
  }
  var full_name = first_name[1] + " " + last_name[1];
  return toTitleCase(full_name);
}

function parse_id(dump) {
  // SID is 9-digits long, following a set of 6 zeros
  var sid = dump.match(/000000([0-9]{9})/);
  if(sid === null || typeof sid === undefined || sid.length < 2) {
    return false;
  }
  return sid[1];
}

function parse_card_number(dump) {
  // card_number is 16 digis long and starts with %B
  var card_number = dump.match(/%B([0-9]{16})/);
  if(card_number === null || typeof card_number === undefined || card_number.length < 2) {
    return false;
  }
  return card_number[1];
}

function toTitleCase(str) {
  return str.replace(/\w\S*/g, function(txt) {
    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
  });
}
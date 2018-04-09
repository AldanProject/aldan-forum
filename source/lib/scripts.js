/* Made by Aldan Project | 2018 */

/* Write the user information in user.php */
function setUserProfile(username, imageURL, email, biography, location, gender)
{
  var container = document.getElementById('user');
  var userTitle = document.getElementById('user-title');
  var userEmail = document.getElementById('user-email');
  var userImage = document.getElementById('user-image');
  var userGender = document.getElementById('user-gender');
  var userBiography = document.getElementById('user-biography');
  var userLocation = document.getElementById('user-location');

  var userGenderP = userGender.childNodes;

  userTitle.innerHTML = username;
  userEmail.innerHTML = '<b>Correo: </b>' + email;
  userImage.src = imageURL;
  switch (gender)
  {
    case 0:
      userGenderP[3].innerHTML = 'Sin especificar';
      break;
    case 1:
      userGenderP[3].innerHTML = 'Masculino';
      break;
    case 2:
      userGenderP[3].innerHTML = 'Femenino';
      break;
  }

  if(biography != '[NONE]')
  {
    var userBiographyP = userBiography.childNodes;
    userBiographyP[3].innerHTML = biography;
    userBiography.style.display = 'block';
  }

  if(location != '[NONE]')
  {
    var userLocationP = userLocation.childNodes;
    userLocationP[3].innerHTML = location;
    userLocation.style.display = 'inline-block';
  }

  container.style.display = 'block';
}

/* Control the navbar buttons */
function setMenuElements(serverURL, activeUser, username)
{
  var loginButton = document.getElementById('login-button');
  var secondButton = document.getElementById('second-button');
  var secondButtonLink = secondButton.childNodes;

  if(activeUser)
  {
    loginButton.style.display = 'none';
    secondButton.classList.toggle('dropdown');
    secondButtonLink[1].innerHTML = username;
    secondButtonLink[1].href = serverURL + 'user/' + username;
  }
  else
  {
    secondButton.classList.toggle('sign-up');
    secondButtonLink[1].innerHTML = 'Registrarse';
    secondButtonLink[1].href = serverURL + "signup";
  }
}

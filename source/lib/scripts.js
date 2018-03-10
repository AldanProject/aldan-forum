/* Made by Aldan Project | 2018 */

function setUserProfile(username, image, email, biography, location, gender)
{
  /* Load the container */
  var container = document.getElementById('user');
  /* Create all the needed elements */

  //Username title
  var userTitle = document.createElement('h2');
  userTitle.classList.toggle('user-title');
  userTitle.innerHTML = username;

  //User email
  var userEmail = document.createElement('p');
  userEmail.classList.toggle('user-email');
  userEmail.innerHTML = "<b>Correo: </b>" + email;

  //Create table
  var table = document.createElement('table');
  table.id = 'user-table';
  table.innerHTML = "";

  var row = document.createElement('tr');
  var columnInfo = document.createElement('td');
  var columnImage = document.createElement('td');
  columnInfo.id = "column-info";
  columnImage.id = "column-image";

  //Creates values for table
  var userImage = document.createElement('img');
  userImage.classList.toggle('user-image');
  userImage.src = image;
  columnImage.appendChild(userImage);

  //Check if 'biography' or 'location' has content
  if(biography != "[NONE]" || location != "[NONE]")
  {
    if(biography != "[NONE]")
    {
      var bioContent = document.createElement('div');
      bioContent.id = 'biography-content';
      bioContent.innerHTML = "<p class='title'>Biografía</p>" + "<p class='user-content'>" + biography + "</p>";
      columnInfo.appendChild(bioContent);
    }
    if(location != "[NONE]")
    {
      var locationContent = document.createElement('div');
      locationContent.id = 'location-content';
      locationContent.innerHTML = "<p class='title'>Locación</p><p class='user-content'>" + location + "</p>";
      columnInfo.appendChild(locationContent);
    }
  }

  //Gender information
  var genderContent = document.createElement('div');
  genderContent.id = 'gender-content';
  var genderText = "Sin establecer";
  switch (gender)
  {
    case '1':
      genderText = "Masculino";
      break;
    case '2':
      genderText = "Femenino";
      break;
  }
  genderContent.innerHTML = "<p class='title'>Género</p><p class='user-content'>" + genderText + "</p>";
  columnInfo.appendChild(genderContent);

  //Append to parent
  row.appendChild(columnInfo);
  row.appendChild(columnImage);
  table.appendChild(row);
  container.appendChild(userTitle);
  container.appendChild(userEmail);
  container.appendChild(table);
}

function createMenuElements(server, activeUser, username)
{
  var container = document.getElementById('navbar');
  //If user is not logged in
  if(!activeUser)
  {
    var signup = document.createElement('li');
    var signupLink = document.createElement('a');
    signup.classList.toggle('left-menu');
    signup.classList.toggle('sign-up');
    signupLink.href = server + 'signup';
    signupLink.innerHTML = 'Registrarse';
    signup.appendChild(signupLink);

    var login = document.createElement('li');
    var loginLink = document.createElement('a');
    login.classList.toggle('left-menu');
    loginLink.href = server + 'login';
    loginLink.innerHTML = 'Iniciar sesión';
    login.appendChild(loginLink);

    container.appendChild(signup);
    container.appendChild(login);
  }
  else
  {
    var user = document.createElement('li');
    var userLink = document.createElement('a');
    user.classList.toggle('left-menu');
    userLink.href = server + "user/" + username;
    userLink.innerHTML = username;
    user.appendChild(userLink);

    var ul = document.createElement('ul');

    var editProfile = document.createElement('li');
    var editProfileLink = document.createElement('a');
    editProfileLink.href = server + 'edit/profile';
    editProfileLink.innerHTML = 'Editar perfil';
    editProfile.appendChild(editProfileLink);

    var logout = document.createElement('li');
    var logoutLink = document.createElement('a');
    logoutLink.href = server + '?logout';
    logoutLink.innerHTML = 'Cerrar sesión';
    logout.appendChild(logoutLink);

    //Append to parent
    ul.appendChild(editProfile);
    ul.appendChild(logout);
    user.appendChild(ul);

    //Apply to container
    container.appendChild(user);
  }
}

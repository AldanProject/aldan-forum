/* Made by Aldan Project | 2018 */
var serverURL;
var forumID, forumTitle, forumDescription;
var postID, postTitle, postCreator, postComments;
var commentID, commentContent, commentDate, commentCreator, creatorAvatar, creatorID;

/* Write the user information in user.php */
function setUserProfile(username, imageURL, email, biography, location, gender)
{
  document.title = 'Perfil de ' + username + ' | Foro de Aldan Project';

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
function setMenuElements(serverURL, activeUser, username, avatarURL)
{
  var loginButton = document.getElementById('login-button');
  var secondButton = document.getElementById('second-button');
  var avatar = document.getElementById('user-avatar');
  var usernameLabel = document.getElementById('username-label');
  var userLink = document.getElementById('user-link');
  var secondButtonLink = secondButton.childNodes;

  if(activeUser)
  {
    loginButton.style.display = 'none';
    secondButton.classList.toggle('dropdown');
    secondButtonLink[1].style.display = "none";
    avatar.src = avatarURL;
    avatar.style.display = "inline-block";
    usernameLabel.innerHTML = username;
    userLink.href = serverURL + 'user/' + username;
  }
  else
  {
    secondButtonLink[1].innerHTML = 'Registrarse';
    secondButtonLink[1].href = serverURL + "signup";
  }
}

/* Forum link */
function callForumPage(forumDiv)
{
  window.location.href = "forum/" + forumDiv.id;
}

/* Add forums */
function addForum()
{
  //Search for main-container div
  var mainContainer = document.getElementById('main-container');
  for(var i = 0; i < forumID.length; i++)
  {
    //Create a new div
    var mainDiv = document.createElement('div');
    mainDiv.id = forumID[i];
    mainDiv.classList.add('forum-box');
    mainDiv.setAttribute('onClick', 'callForumPage(this);');
    //Create a image (forum icon)
    var icon = document.createElement('img');
    icon.classList.add('forum-icon');
    icon.src = 'img/forum/' + forumID[i] + '.png';
    //Create title
    var title = document.createElement('p');
    title.classList.add('forum-title');
    title.innerHTML = forumTitle[i];
    //Create description
    var description = document.createElement('p');
    description.classList.add('forum-description');
    description.innerHTML = forumDescription[i];
    //Add arrow
    var arrow = document.createElement('img');
    arrow.classList.add('arrow');
    arrow.src = 'img/assets/arrow.png';
    //Append to mainDiv
    mainDiv.appendChild(icon);
    mainDiv.appendChild(title);
    mainDiv.appendChild(description);
    mainDiv.appendChild(arrow);
    //Append to mainContainer
    mainContainer.appendChild(mainDiv);
  }
}

/* Post link */
function callPostPage(forumDiv)
{
  window.location.href = forumID + "/post/" + forumDiv.id;
}

/* Add posts */
function addPost()
{
  //Search for main-container div
  var mainContainer = document.getElementById('main-container');
  for(var i = 0; i < postID.length; i++)
  {
    //Create new div
    var mainDiv = document.createElement('div');
    mainDiv.classList.add('forum-box');
    mainDiv.classList.add('post');
    if(i == 0)
      mainDiv.classList.add('first-post');
    mainDiv.id = postID[i];
    mainDiv.setAttribute('onClick', 'callPostPage(this);');
    //Create title
    var title = document.createElement('p');
    title.classList.add('forum-title');
    title.innerHTML = postTitle[i];
    //Create post's creator
    var creator = document.createElement('p');
    creator.classList.add('post-creator');
    creator.innerHTML = "por " + postCreator[i];
    //Create # of postComments
    var comments = document.createElement('p');
    comments.classList.add('num-post');
    comments.innerHTML = "<b>Número de comentarios: </b>" + postComments[i];
    //Create arrow
    var arrow = document.createElement('img');
    arrow.classList.add('arrow');
    arrow.src = '../img/assets/arrow.png';
    //Append to mainDiv
    mainDiv.appendChild(title);
    mainDiv.appendChild(creator);
    mainDiv.appendChild(comments);
    mainDiv.appendChild(arrow);
    //Append to mainContainer
    mainContainer.append(mainDiv);
  }
}

/* User link */
function searchUser(username)
{
  window.location.href = serverURL + 'user/' + username;
}

/* Create post */
function createPost(title, date, content, avatar, username, forumName, forumID)
{
  document.title = title + ' | Foro de Aldan Project';
  /* Search tags */
  var forumStructure = document.getElementById('forum-structure');
  var post = document.getElementById('post');
  var postTitle = document.getElementById('post-title');
  var postDate = document.getElementById('post-date');
  var postContent = document.getElementById('post-content');
  var userImage = document.getElementById('user-image');
  var usernameText = document.getElementById('username');
  /* Apply changes */
  postTitle.innerHTML = title;
  postDate.innerHTML = '<b>Fecha de publicación: </b>' + date;
  postContent.innerHTML = content;
  userImage.src = avatar;
  var userClick = "searchUser('" + username + "')";
  userImage.setAttribute('onClick', userClick);
  usernameText.innerHTML = username;
  usernameText.setAttribute('onClick', userClick);
  forumStructure.innerHTML = '<a href="' + serverURL + 'forum/' + forumID + '">' + forumName + "</a> > " + title;
  /* Show containers */
  forumStructure.style.display = "block";
  post.style.display = "table";
}

/* Apply style on text areas */
function applyStyle(option)
{
  var newText;
  var txtarea = document.getElementById('comment-area');
  var start = txtarea.selectionStart;
  var finish = txtarea.selectionEnd;
  var selected = txtarea.value.substring(start, finish);
  var length = txtarea.value.lenght;

  switch (option)
  {
    case 0:
      /* Bold */
      newText = "<b>" + selected + "</b>";
      break;
    case 1:
      /* Italic */
      newText = "<i>" + selected + "</i>";
      break;
    case 2:
      /* Italic */
      newText = "<u>" + selected + "</u>";
      break;
    case 3:
      var link = prompt('Inserta el enlace');
      newText = '<a href="' + link + '">' + selected + "</a>";
      break;
  }
  txtarea.value = txtarea.value.substring(0, start) + newText + txtarea.value.substring(finish, length);
}

/* Show comment box */
function showCommentBox()
{
  var commentBox = document.getElementById('comment-box');
  commentBox.style.display = "block";
}

/* Create comments */
function createComments()
{
  var commentsContainer = document.getElementById('user-comments');
  for(var i = 0; i < commentID.length; i++)
  {
    /* Option buttons */
    var buttons = document.createElement('div');
    buttons.classList.add('option-buttons');
    buttons.id = creatorID[i];
    buttons.classList.add('comment-options');
    var deleteForm = document.createElement('form');
    deleteForm.method = 'post';
    deleteForm.style.display = 'inline-block';
    deleteForm.setAttribute('onsubmit', "return confirm('Está a punto de eliminar el comentario, ¿desea continuar?')");
    var hiddenID = document.createElement('input');
    hiddenID.type = 'hidden';
    hiddenID.name = 'delete-comment';
    hiddenID.value = commentID[i];
    var deleteBtn = document.createElement('input');
    deleteBtn.type = 'submit';
    deleteBtn.classList.add('delete');
    deleteBtn.value = 'Eliminar comentario';
    var modifyBtn = document.createElement('input');
    modifyBtn.type = 'button';
    modifyBtn.value = 'Modificar comentario';
    modifyBtn.name = commentID[i];
    /* Main structure */
    var table = document.createElement('table');
    table.id = "comment-" + commentID[i];
    table.classList.add('post-container');
    table.classList.add('user-comment');
    var tr = document.createElement('tr');
    tr.classList.add('post-border');
    /* Content */
    var content = document.createElement('td');
    content.classList.add('content');
    var date = document.createElement('p');
    date.classList.add('date');
    date.innerHTML = '<b>Fecha de comentario: </b>' + commentDate[i];
    var comment = document.createElement('p');
    comment.classList.add('content');
    comment.innerHTML = commentContent[i];
    /* User */
    var user = document.createElement('td');
    user.classList.add('user');
    var avatar = document.createElement('img');
    avatar.classList.add('user-image');
    avatar.classList.add('link');
    avatar.classList.add('post-image');
    avatar.src = creatorAvatar[i];
    var userLink = "searchUser('" + commentCreator[i] + "');";
    avatar.setAttribute('onClick', userLink);
    var username = document.createElement('p');
    username.classList.add('user-title');
    username.classList.add('link');
    username.classList.add('post-username');
    username.innerHTML = commentCreator[i];
    username.setAttribute('onClick', userLink);
    /* Join */
    deleteForm.appendChild(hiddenID);
    deleteForm.appendChild(deleteBtn);
    buttons.appendChild(deleteForm);
    buttons.appendChild(modifyBtn);
    content.appendChild(date);
    content.appendChild(comment);
    user.appendChild(avatar);
    user.appendChild(username);
    tr.appendChild(buttons);
    tr.appendChild(content);
    tr.appendChild(user);
    table.appendChild(tr);
    /* Append to main container */
    commentsContainer.appendChild(table);
  }
}

/* Show option buttons */
function showOptionButtons()
{
  var buttons = document.getElementById('option-buttons');
  buttons.style.display = "block";
}

/* Show option buttons for comments */
function showOptionComments(user)
{
  var comments = document.getElementsByClassName('comment-options');
  for(var i = 0; i < comments.length; i++)
  {
    if(user == comments[i].id)
    {
      comments[i].style.display = 'block';
    }
  }
}

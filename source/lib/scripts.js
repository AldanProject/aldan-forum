/* Made by Aldan Project | 2018 */
var serverURL;
var forumID, forumTitle, forumDescription;
var postID, postTitle, postCreator, postComments;
var commentID, commentContent, commentDate, commentCreator, creatorAvatar, creatorID;
var tableAvatar, tableUsername, tableScore;

/* Write the user information in user.php */
function setUserProfile(username, imageURL, email, biography, location, gender, score)
{
  document.title = 'Perfil de ' + username + ' | Foro de Aldan Project';

  var container = document.getElementById('user');
  var userTitle = document.getElementById('user-title');
  var userEmail = document.getElementById('user-email');
  var userImage = document.getElementById('user-image');
  var userGender = document.getElementById('user-gender');
  var userBiography = document.getElementById('user-biography');
  var userLocation = document.getElementById('user-location');
  var userScore = document.getElementById('user-score');

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
      userGenderP[3].innerHTML = 'Sin especificar';
      break;
    case 2:
      userGenderP[3].innerHTML = 'Masculino';
      break;
    case 3:
      userGenderP[3].innerHTML = 'Femenino';
      break;
  }

  var userScoreP = userScore.childNodes;
  userScoreP[3].innerHTML = score;

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
  var download = document.getElementById('download-button');
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
    download.style.display = "flex";
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
  window.location.href = forumDiv.id + "/";
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
  window.location.href = "post/" + forumDiv.id + "/";
}

/* New post link */
function newPostLink()
{
  var editLink = document.getElementById('add-link');
  editLink.href = serverURL + "new/post/" + forumID;
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
function createPost(title, date, content, avatar, username, forumName, forumID, postID)
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
  var editBtn = document.getElementById('edit-post');
  /* Apply changes */
  postTitle.innerHTML = title;
  postDate.innerHTML = '<b>Fecha de publicación: </b>' + date;
  postContent.innerHTML = content;
  userImage.src = avatar;
  var userClick = "searchUser('" + username + "')";
  userImage.setAttribute('onClick', userClick);
  usernameText.innerHTML = username;
  usernameText.setAttribute('onClick', userClick);
  forumStructure.innerHTML = '<a href="' + serverURL + forumID + "/" + '">' + forumName + "</a> > " + title;
  editBtn.id = postID;
  editBtn.setAttribute('onClick', 'callEditPost(this)');
  /* Show containers */
  forumStructure.style.display = "block";
  post.style.display = "table";
}

/* Apply style on text areas */
function applyStyle(option, commentBoxName)
{
  var newText;
  var txtarea = document.getElementById(commentBoxName);
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
      /* Link */
      var link = prompt('Inserta el enlace');
      if(link != null)
      {
        newText = '<a href="' + link + '">' + selected + "</a>";
      }
      break;
    case 4:
      /* Break line */
      newText = "<br/>";
      break;
    case 5:
      /* Center */
      newText = "<center>" + selected + "</center>";
      break;
    case 6:
      /* Subtitle */
      newText = "<h2>" + selected + "</h2>";
      break;
  }

  if(newText)
  {
    txtarea.value = txtarea.value.substring(0, start) + newText + txtarea.value.substring(finish, length);
  }
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
    /* Delete form */
    var deleteForm = document.createElement('form');
    deleteForm.method = 'post';
    deleteForm.classList.add('options-form');
    deleteForm.setAttribute('onsubmit', "return confirm('Está a punto de eliminar el comentario, ¿desea continuar?')");
    var deleteID = document.createElement('input');
    deleteID.type = 'hidden';
    deleteID.name = 'delete-comment';
    deleteID.value = commentID[i];
    var deleteBtn = document.createElement('input');
    deleteBtn.type = 'submit';
    deleteBtn.classList.add('delete');
    deleteBtn.value = 'Eliminar comentario';
    /* Modify form */
    var modifyBtn = document.createElement('input');
    modifyBtn.type = 'button';
    modifyBtn.id = commentID[i];
    modifyBtn.setAttribute('onClick', 'callEditComment(this)');
    modifyBtn.value = 'Modificar comentario';
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
    deleteForm.appendChild(deleteID);
    deleteForm.appendChild(deleteBtn);
    buttons.appendChild(deleteForm);
    buttons.appendChild(modifyBtn);
    content.appendChild(date);
    content.appendChild(comment);
    user.appendChild(avatar);
    user.appendChild(username);
    tr.appendChild(content);
    tr.appendChild(user);
    table.appendChild(buttons);
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
    if(user == comments[i].id || user == 1)
    {
      comments[i].style.display = 'block';
    }
  }
}

/* Show new post button or new forum */
function showNewPost()
{
  var button = document.getElementById('option-buttons');
  button.style.display = 'block';
}

/* Set page title */
function setPageTitle(title)
{
  document.title = title + " | Foro de Aldan Project";
}

/* Confirm button */
function confirmButton(message)
{
  if(window.confirm(message))
  {

  }
}

/* Create leaderboards */
function createLeaderboards()
{
  //Search for main-container div
  var mainContainer = document.getElementById('main-container');
  for(var i = 0; i < tableUsername.length; i++)
  {
    //Create new div
    var mainDiv = document.createElement('div');
    mainDiv.classList.add('forum-box');
    mainDiv.classList.add('post');
    if(i <= 0)
    {
      mainDiv.classList.add('first-post');
    }
    mainDiv.id = tableUsername[i];
    mainDiv.setAttribute('onClick', 'searchUser(this.id);');
    //Create avatar
    var avatar = document.createElement('img');
    avatar.classList.add('forum-icon');
    avatar.classList.add('leaderboards-icon');
    avatar.src = tableAvatar[i];
    //Create username
    var username = document.createElement('p');
    username.classList.add('forum-title');
    username.innerHTML = tableUsername[i];
    //Create score
    var score = document.createElement('p');
    score.classList.add('forum-description');
    score.innerHTML = "<b>Puntuación: </b>" + tableScore[i];
    //Create arrow
    var arrow = document.createElement('img');
    arrow.classList.add('arrow');
    arrow.src = 'img/assets/arrow.png';
    //Append to mainDiv
    mainDiv.appendChild(avatar);
    mainDiv.appendChild(username);
    mainDiv.appendChild(score);
    mainDiv.appendChild(arrow);
    //Append to mainContainer
    mainContainer.append(mainDiv);
  }
}

/* Cancel comment */
function hideBlackScreen(forum, post)
{
  window.location.href = serverURL + forum + "/post/" + post + "/";
}

/* Show edit comment form */
function showEditComment(commentID, commentContent)
{
  var commentArea = document.getElementById('comment-area-edit');
  var commentIDHidden = document.getElementById('comment-id');
  var blackScreen = document.getElementById('black-screen');
  commentIDHidden.value = commentID;
  commentArea.innerHTML = commentContent;

  blackScreen.style.display = 'flex';
}

/* Show edit post form */
function showEditPost(postID, postTitle, postContent)
{
  var commentArea = document.getElementById('comment-area-edit-post');
  var postInput = document.getElementById('title-edit');
  var blackScreen = document.getElementById('black-screen-post');
  postInput.value = postTitle;
  commentArea.innerHTML = postContent;

  blackScreen.style.display = 'flex';
}

/* Call edit comment */
function callEditComment(comment)
{
  window.location.href = "edit-comment/" + comment.id;
}

/* Call edit post */
function callEditPost(post)
{
  window.location.href = "edit-post/" + post.id;
}
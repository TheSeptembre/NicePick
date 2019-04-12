<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"  />
<title>Déplacer un élément à la souris</title>

<style>

#square
{
  position:absolute;
  height:100px;
  width:100px;
  background-color:red;
}
</style>
</head>
<body>
  <div id="square" onmousedown="on_mouse_down_square(event)"></div>
</body>
</html>
var mouse_down = false;

function on_mouse_down_square(event) {
 mouse_down=true;
}

function on_mouse_up(event){
 mouse_down=false;
}

document.onmousemove = on_mouse_move;

document.onmouseup = on_mouse_up;

function on_mouse_move(event) {
  if (mouse_down === true) {
    document.querySelector('#square').style.left = event.clientX-50+'px';
    document.querySelector('#square').style.top = event.clientY-50+'px';

  }
}

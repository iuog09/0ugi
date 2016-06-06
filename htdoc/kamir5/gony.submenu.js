/**
 * submenu function by happygony(20041030)
 */

function layerSubMenu(showId)
{
	var obj = document.getElementById(showId);

	if (layerSubMenu.prev != undefined && layerSubMenu.prev.id == showId) {
		return true;
	}

	if (layerSubMenu.prev != undefined && layerSubMenu.prev != null) {
		if (layerSubMenu.prev.currentAlpha != 100) layerSubMenu.prev.currentAlpha = 0;
		clearTimeout(layerSubMenu.prev.time);
		layerSubMenu.hide(layerSubMenu.prev);
	}

	if (obj.currentAlpha != undefined) {
		obj.currentAlpha = 0;
		clearTimeout(obj.time);
	}
	layerSubMenu.show(obj);
	layerSubMenu.prev = obj;
}

layerSubMenu.show = function(obj)
{
	obj.style.display = 'block';

	if (obj.sourcePosition == undefined) {
		obj.sourcePosition = parseInt(obj.offsetLeft);
		obj.style.left = (obj.sourcePosition + 20) + 'px';
	}
	if (obj.currentAlpha == undefined) {
		obj.currentAlpha = 0;
	}

	if (false && obj.style.filter != undefined) {
		if (obj.currentAlpha < 100) {
			obj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity='+obj.currentAlpha+')';
			obj.style.left = (parseInt(obj.style.left) - 1) + 'px';
			obj.currentAlpha += 20;
			obj.time = setTimeout('layerSubMenu.show(document.getElementById("'+obj.id+'"))', 20);
		} else {
			obj.style.filter = null;
			obj.style.left = obj.sourcePosition + 'px';
			clearTimeout(obj.time);
		}
	} else {
		obj.style.left = obj.sourcePosition;
	}
}

layerSubMenu.hide = function(obj)
{
	if (false && obj.style.filter != undefined) {
		if (obj.currentAlpha > 0) {
			obj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity='+obj.currentAlpha+')';
			obj.style.left = (parseInt(obj.style.left) + 1) + 'px';
			obj.currentAlpha -= 20;
			obj.time = setTimeout('layerSubMenu.hide(document.getElementById("'+obj.id+'"))', 20);
			return true;
		} else {
			obj.style.filter = null;
			obj.style.left = (obj.sourcePosition + 20) + 'px';
			clearTimeout(obj.time);
		}
	}

	obj.style.display = 'none';
}

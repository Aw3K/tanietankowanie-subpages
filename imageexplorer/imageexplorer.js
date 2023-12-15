var GlobalImageList = [];

function readTextFile(file) {
	var rawFile = new XMLHttpRequest();
	rawFile.open("GET", file, false);
	rawFile.onreadystatechange = function () { }
	rawFile.send();
	return rawFile.responseText;
}

function getCorrectData(tab, searched) {
	for (let j = 0; j < tab.length; j++) {
		if (searched.includes(tab[j][1])) return tab[j][0];
	}
	return null;
}

function changeImage(direction) {
	if (GlobalImageList.length == 0) return;
	var value = imageFrame.attributes.value;
	if (direction == "left") {
		if (value > 0) {
			setImageData(--value);
		} else setImageData(0);
	} else if (direction == "right") {
		if (value < GlobalImageList.length - 1) {
			setImageData(++value);
		} else setImageData(GlobalImageList.length - 1);
	}
	imageFrame.attributes.value = value;
}

function setImageData(i) {
	imageNumber.innerHTML = i + 1 + "/" + GlobalImageList.length;
	imageDataField.innerHTML = GlobalImageList[i][0] + " - " + GlobalImageList[i][1];
	imageFrame.attributes.value = i;
	imageFrame.innerHTML = "<center><image id=\"image\" src=\"" + imageLoc + GlobalImageList[i][0] + "\"></center>";
}

function deleteImage() {
	if (GlobalImageList.length == 0) return;
	fetch("./delimage.php?img=" + GlobalImageList[imageFrame.attributes.value][0]).catch((error) => {
		console.warn(error);
	});
	GlobalImageList.splice(imageFrame.attributes.value, 1);
	changeImage('right');
}

function reloadImages() {
	var fileData = readTextFile(fileLoc).split("\r\n");
	for (let i in fileData) fileData[i] = fileData[i].split(' ');
	$.ajax({
		url: "listfiles.php",
		type: "POST",
		success: function (out) {
			GlobalImageList = [];
			if (out.length == 0) {
				imageDataField.innerHTML = "BRAK ZDJĘĆ";
				return;
			}
			for (let i in out) {
				let response = getCorrectData(fileData, out[i]);
				GlobalImageList.push([out[i], response]);
			}
			setImageData(0);
		},
		dataType: "json"
	});
}

$('html').keydown(function (e) {
	if (e.keyCode == 46) {
		deleteImage();
	}
});
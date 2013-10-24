/*return original Size*/
function getNaturalSize(image){
	var run, mem, w, h, key = 'actual';
	
	// for Firefox, Safari, Google Chrome
	if ('naturalWidth' in image) {
	return {width: image.naturalWidth, height: image.naturalHeight};
	}
	if ('src' in image) { // HTMLImageElement
	
	if (image[key] && image[key].src === image.src) {return image[key];}
	if (document.uniqueID) { // for IE
	w = $(image).css('width');
	h = $(image).css('height');
	} else { // for Opera and Other
	mem = {w: image.width, h: image.height}; // keep current style
	$(this).removeAttr('width').removeAttr('height').css({width:'', height:''});    // Remove attributes in case img-element has set width and height (for webkit browsers)
	w = image.width;
	h = image.height;
	image.width  = mem.w; // restore
	image.height = mem.h;
	}
	return image[key] = {width: w, height: h, src: image.src}; // bond
	}
	// HTMLCanvasElement
	return {width: image.width, height: image.height};
}
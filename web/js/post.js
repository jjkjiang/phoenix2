document.getElementById('post_body').addEventListener('keyup', function () {
	this.style.height = 0;
	this.style.height = this.scrollHeight + 'px';
}, false);

function Editor(input, preview) {
    this.update = function () {
        preview.innerHTML = markdown.toHTML(input.value);
    };
    input.editor = this;
    this.update();
}
var $ = function (id) { return document.getElementById(id); };
new Editor($("post_body"), $("preview"));
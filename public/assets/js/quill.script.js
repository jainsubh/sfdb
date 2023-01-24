$(document).ready(function () {
    var quill = new Quill('#editor', {
        modules: {
            syntax: !0,
            toolbar: [
                [{
                    font: []
                }, {
                    size: []
                }],
                ["bold", "italic", "underline", "strike"],
                [{
                    color: []
                }, {
                    background: []
                }],
                [{
                    script: "super"
                }, {
                    script: "sub"
                }],
                [{
                    header: "1"
                }, {
                    header: "2"
                }, "blockquote", "code-block"],
                [{
                    list: "ordered"
                }, {
                    list: "bullet"
                }, {
                    indent: "-1"
                }, {
                    indent: "+1"
                }],
                ["direction", {
                    align: []
                }],
                ["link", "image", "video", "formula"],
                ["clean"]
            ]
        },
        theme: 'snow',
        readOnly: true,
        
    });
});

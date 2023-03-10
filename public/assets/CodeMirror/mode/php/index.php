<!doctype html>

<title>CodeMirror: PHP mode</title>
<meta charset="utf-8"/>

<link rel="stylesheet" href="../../lib/codemirror.css">
<script src="../../lib/codemirror.js"></script>
<script src="../../addon/edit/matchbrackets.js"></script>
<script src="../htmlmixed/htmlmixed.js"></script>
<script src="../xml/xml.js"></script>
<script src="../javascript/javascript.js"></script>
<script src="../css/css.js"></script>
<script src="../clike/clike.js"></script>
<script src="php.js"></script>
<style>.CodeMirror {border-top: 1px solid black; border-bottom: 1px solid black;}</style>

<form>
  <textarea id="code" name="code">
<?php
$a = array('a' => 1, 'b' => 2, 3 => 'c');

echo "$a[a] ${a[3] /* } comment */} {$a[b]} \$a[a]";

function hello($who) {
	return "Hello $who!";
}
?>
<p>The program says <?= hello("World") ?>.</p>
<script>
	alert("And here is some JS code"); // also colored
</script>
</textarea></form>

    <script>
      var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true
      });
    </script>

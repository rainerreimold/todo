<?php

include 'inc/header.php';
		
		echo'<br>
<br><!--
<form enctype="multipart/form-data" method="post" class="body" action="fehler/eintragen" accept-charset="UTF-8"> -->
<form  title="das Fehlerformular" name="fehlerformular" action="eintragen" method="post">
<Table>
<tr>
<td align="right">Betrifft das Projekt:</td>
<td>';

		$oProjekt = new Projekt(1);
	 	$oProjekt->Projekteausgeben();
		echo '<a href="'.PFAD.'/'.APPNAME.'/projekt/uebersicht" title="Link noch zu ändern !!! Projekt&uuml;bersicht - Neues anlegen !"><b>+</b></a></td>
</tr>

<tr>
<td align="right">Url:</td>
<td><input title="in Adressleiste <strg a>, <strg c>, dann hierher und <strg v>" name="url" type="text" size="30"/></td>
</tr>

<tr>
<td align="right">Fehler Kurzbeschreibung:</td>
<td><input title="Kurz und Knackig das Problem kennzeichen" name="kurzbeschreibung" type="text" size="30"/></td>
</tr>

<tr>
<td align="right">Fehler Gesamtbeschreibung:</td>
<td><textarea title="Was passiert genau, wenn was gemacht wurde. Gibt es eine Fehlerausgabe (Code)" name="fehler" cols="45" rows="10"></textarea></td>
</tr>

<!-- hier bietet es sich den wysiwygEditor einzusetzen -->
<!-- Gets replaced with TinyMCE, remember HTML in a textarea should be encoded 
	<textarea id="elm1" name="elm1" rows="15" cols="80" style="width: 80%">
		&lt;p&gt;
		&lt;img src="media/logo.jpg" alt=" " hspace="5" vspace="5" width="250" height="48" align="right" /&gt;	TinyMCE is a platform independent web based Javascript HTML &lt;strong&gt;WYSIWYG&lt;/strong&gt; editor control released as Open Source under LGPL by Moxiecode Systems AB. It has the ability to convert HTML TEXTAREA fields or other HTML elements to editor instances. TinyMCE is very easy to integrate into other Content Management Systems.
		&lt;/p&gt;
		&lt;p&gt;
		We recommend &lt;a href="http://www.getfirefox.com" target="_blank"&gt;Firefox&lt;/a&gt; and &lt;a href="http://www.google.com" target="_blank"&gt;Google&lt;/a&gt; &lt;br /&gt;
		&lt;/p&gt;
	</textarea>
-->
<!--   -->
<tr>
<td align="right">Ziel Beschreibung:</td>
<td><textarea  title="Was genau soll erreicht werden. Je genauer die Beschreibung desto einfacher die Lösungsansätze" name="ziel" cols="45=" rows="10"></textarea></td>
</tr>
<tr>
<td align="right">Wunsch Beschreibung:</td>
<td><textarea title="Was w&auml;re w&uuml;nschenswert aber nicht zwingend notwendig" name="wunsch" cols="45" rows="10"></textarea></td>
</tr>
<tr>
<tr>
<td align="right">Priorit&auml;t:</td>
<td><select name="prio" id="prioritaet" title="Hier die Priorit&auml;t festlegen (Nicht jedes Problem muss sofort erledigt werden !)">
	<option value="1">Sofort erledigen</option>
	<option value="2">hoch</option>
	<option selected value="3">mittel</option>
	<option value="4">bei Gelegenheit</option>
	</select>
</td>
</tr>
<tr>
<td></td>
<td><input name="abschicken" type="submit" value="abschicken" /></td>
</tr>


</Table>
</form>

<br />';


	
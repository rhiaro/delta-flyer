<p>
    <label for="startname">From</label> <input type="text" name="startname" id="startname"<?=(isset($_POST['startname'])) ? ' value="'.$_POST['startname'].'"' : ''?> />
</p>
<p>
    <div id="startMap"></div>
    <input type="hidden" name="startlat" id="startlat"<?=(isset($_POST['startlat'])) ? ' value="'.$_POST['startlat'].'"' : ''?> />
    <input type="hidden" name="startlng" id="startlng"<?=(isset($_POST['startlng'])) ? ' value="'.$_POST['startlng'].'"' : ''?> />
</p>
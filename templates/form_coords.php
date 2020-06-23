<p>
    <label for="startname">From</label> <input type="text" name="startname" id="startname"<?=(isset($_POST['startname'])) ? ' value="'.$_POST['startname'].'"' : ''?> />
</p>
<p>
    <div id="startMap"></div>
    <input type="hidden" name="startlat" id="startlat"<?=(isset($_POST['startlat'])) ? ' value="'.$_POST['startlat'].'"' : ''?> />
    <input type="hidden" name="startlng" id="startlng"<?=(isset($_POST['startlng'])) ? ' value="'.$_POST['startlng'].'"' : ''?> />
</p>
<p>
    <label for="endname">To</label> <input type="text" name="endname" id="endname"<?=(isset($_POST['endname'])) ? ' value="'.$_POST['endname'].'"' : ''?> />
</p>
<p>
    <div id="endMap"></div>
    <input type="hidden" name="endlat" id="endlat"<?=(isset($_POST['endlat'])) ? ' value="'.$_POST['endlat'].'"' : ''?> />
    <input type="hidden" name="endlng" id="endlng"<?=(isset($_POST['endlng'])) ? ' value="'.$_POST['endlng'].'"' : ''?> />
</p>
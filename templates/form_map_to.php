<p>
    <label for="endname">To</label> <input type="text" name="endname" id="endname"<?=(isset($_POST['endname'])) ? ' value="'.$_POST['endname'].'"' : ''?> />
</p>
<p>
    <div id="endMap"></div>
    <input type="hidden" name="endlat" id="endlat"<?=(isset($_POST['endlat'])) ? ' value="'.$_POST['endlat'].'"' : ''?> />
    <input type="hidden" name="endlng" id="endlng"<?=(isset($_POST['endlng'])) ? ' value="'.$_POST['endlng'].'"' : ''?> />
</p>
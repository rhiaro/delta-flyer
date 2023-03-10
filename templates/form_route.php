        <p>
          <label for="name">Name</label>
          <input type="text" name="name" id="name"<?=(isset($_POST['name'])) ? ' value="'.$_POST['name'].'"' : ''?> />
        </p>
        <p>
          <label for="summary">Summary</label>
          <input type="text" name="summary" id="summary"<?=(isset($_POST['summary'])) ? ' value="'.$_POST['summary'].'"' : ''?> />
        </p>
        <span id="toggleFromMap">change input</span>
        <div id="fromInput">
          <p>
            <label for="from">From</label>
            <select name="from_uri" id="from_uri">
              <option>--</option>
              <?foreach($locations as $location):?>
                <option value="<?=$location['id']?>"<?=isset($_POST['from_uri']) && $location['id']==$_POST['from_uri'] ? " selected": ""?>><?=$location['name']?></option>
              <?endforeach?>
            </select>
          </p>
        </div>
        <span id="toggleToMap">change input</span>
        <div id="toInput">
          <p>
            <label for="to">To</label>
            <select name="to_uri" id="to_uri">
              <option>--</option>
              <?foreach($locations as $location):?>
                <option value="<?=$location['id']?>"<?=isset($_POST['to_uri']) && $location['id']==$_POST['to_uri'] ? " selected": ""?>><?=$location['name']?></option>
              <?endforeach?>
            </select>
          </p>
        </div>

        <p>
          <label>Start</label>
          <select name="startyear" id="startyear">
            <?for($i=date("Y");$i>=2008;$i--):?>
              <option value="<?=$i?>"<?=(isset($_POST['startyear']) && $i==$_POST['startyear']) ? " selected" : ""?>><?=$i?></option>
            <?endfor?>
          </select>
          <select name="startmonth" id="startmonth">
            <?for($i=1;$i<=12;$i++):?>
              <? $i = date("m", strtotime("2016-$i-01")); ?>
              <option value="<?=$i?>"
                <?=((isset($_POST['startmonth']) && $_POST['startmonth'] == $i) ? " selected" : (!isset($_POST['startmonth']) && date("n") == $i)) ? " selected" : ""?>>
                <?=date("M", strtotime("2016-$i-01"))?>
              </option>
            <?endfor?>
          </select>
          <select name="startday" id="startday">
            <?for($i=1;$i<=31;$i++):?>
              <? $i = date("d", strtotime("2016-01-$i")); ?>
              <option value="<?=$i?>"
                <?=((isset($_POST['startday']) && $_POST['startday'] == $i) ? " selected" : (!isset($_POST['startday']) && date("j") == $i)) ? " selected" : ""?>>
                <?=$i?>
              </option>
            <?endfor?>
          </select>
          <input type="text" name="starttime" id="starttime" value="<?=(isset($_POST['starttime'])) ? $_POST['starttime'] : date("H:i:s")?>" size="8" />
          <input type="text" name="startzone" id="startzone" value="<?=(isset($_POST['startzone'])) ? $_POST['startzone'] : date("P")?>" size="5" />
          <span id="reload"></span>
        </p>
        <p>
          <label>End</label>
          <select name="endyear" id="endyear">
            <?for($i=date("Y");$i>=2008;$i--):?>
              <option value="<?=$i?>"<?=(isset($_POST['endyear']) && $i==$_POST['endyear']) ? " selected" : ""?>><?=$i?></option>
            <?endfor?>
          </select>
          <select name="endmonth" id="endmonth">
            <?for($i=1;$i<=12;$i++):?>
              <? $i = date("m", strtotime("2016-$i-01")); ?>
              <option value="<?=$i?>"
                <?=((isset($_POST['endmonth']) && $_POST['endmonth'] == $i) ? " selected" : (!isset($_POST['endmonth']) && date("n") == $i)) ? " selected" : ""?>>
                <?=date("M", strtotime("2016-$i-01"))?>
              </option>
            <?endfor?>
          </select>
          <select name="endday" id="endday">
            <?for($i=1;$i<=31;$i++):?>
              <? $i = date("d", strtotime("2016-01-$i")); ?>
              <option value="<?=$i?>"
                <?=((isset($_POST['endday']) && $_POST['endday'] == $i) ? " selected" : (!isset($_POST['endday']) && date("j") == $i)) ? " selected" : ""?>>
                <?=$i?>
              </option>
            <?endfor?>
          </select>
          <input type="text" name="endtime" id="endtime" value="<?=(isset($_POST['endtime'])) ? $_POST['endtime'] : date("H:i:s")?>" size="8" />
          <input type="text" name="endzone" id="endzone" value="<?=(isset($_POST['endzone'])) ? $_POST['endzone'] : date("P")?>" size="5" />
          <span id="reload"></span>
        </p>

        <p>
          <label for="content">Description</label>
          <textarea name="content" id="content"><?=(isset($_POST['content'])) ? $_POST['content'] : ''?></textarea>
        </p>

        <p>
          <label for="tags">Tags</label>
          <? if(!isset($_POST['tags'])) { $_POST['tags'] = array(); } ?>
          <input type="text" name="tags[string]" id="tags"<?=(isset($_POST['tags']['string'])) ? ' value="'.$_POST['tags']['string'].'"' : ''?> />
        </p>
        <p>
          <label></label>
          <span>
            <?foreach($tags as $label => $tag):?>
              <input type="checkbox" value="<?=$tag?>" name="tags[]" id="<?=$label?>"<?=(in_array($tag, $_POST['tags'])) ? " checked" : ""?> /><label for="<?=$label?>"><?=$label?></label>
            <?endforeach?>
          </span>
        </p>

        <p>
          <label>Published</label>
          <select name="year" id="year">
            <?for($i=date("Y");$i>=2008;$i--):?>
              <option value="<?=$i?>"<?=(isset($_POST['year']) && $i==$_POST['year']) ? " selected" : ""?>><?=$i?></option>
            <?endfor?>
          </select>
          <select name="month" id="month">
            <?for($i=1;$i<=12;$i++):?>
              <? $i = date("m", strtotime("2016-$i-01")); ?>
              <option value="<?=$i?>"
                <?=((isset($_POST['month']) && $_POST['month'] == $i) ? " selected" : (!isset($_POST['month']) && date("n") == $i)) ? " selected" : ""?>>
                <?=date("M", strtotime("2016-$i-01"))?>
              </option>
            <?endfor?>
          </select>
          <select name="day" id="day">
            <?for($i=1;$i<=31;$i++):?>
              <? $i = date("d", strtotime("2016-01-$i")); ?>
              <option value="<?=$i?>"
                <?=((isset($_POST['day']) && $_POST['day'] == $i) ? " selected" : (!isset($_POST['day']) && date("j") == $i)) ? " selected" : ""?>>
                <?=$i?>
              </option>
            <?endfor?>
          </select>
          <input type="text" name="time" id="time" value="<?=(isset($_POST['time'])) ? $_POST['time'] : date("H:i:s")?>" size="8" />
          <input type="text" name="zone" id="zone" value="<?=(isset($_POST['endzone'])) ? $_POST['endzone'] : date("P")?>" size="5" />
          <span id="reload"></span>
        </p>

        <p>
          <input type="submit" name="submit" value="Log" />
        </p>
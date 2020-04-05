        <p>
          <label for="summary">Summary</label>
          <input type="text" name="summary" id="summary" />
        </p>

        <p>
          <label for="from">From</label>
          <input type="text" name="from" id="from" />
        </p>

        <p>
          <label for="to">To</label>
          <input type="text" name="to" id="to" />
        </p>

        <p>
          <label>Start</label> 
          <select name="startyear" id="startyear">
            <option value="2020" selected>2020</option>
            <option value="2019">2019</option>
            <option value="2018">2018</option>
          </select>
          <select name="startmonth" id="startmonth">
            <?for($i=1;$i<=12;$i++):?>
              <option value="<?=date("m", strtotime("2016-$i-01"))?>"<?=(date("n") == $i) ? " selected" : ""?>><?=date("M", strtotime("2016-$i-01"))?></option>
            <?endfor?>
          </select>
          <select name="startday" id="startday">
            <?for($i=1;$i<=31;$i++):?>
              <option value="<?=date("d", strtotime("2016-01-$i"))?>"<?=(date("j") == $i) ? " selected" : ""?>><?=date("d", strtotime("2016-01-$i"))?></option>
            <?endfor?>
          </select>
          <input type="text" name="starttime" id="starttime" value="<?=date("H:i:s")?>" size="8" />
          <input type="text" name="startzone" id="startzone" value="<?=date("P")?>" size="5" />
          <span id="reload"></span>
        </p>
        <p>
          <label>End</label> 
          <select name="endyear" id="endyear">
            <option value="2020" selected>2020</option>
            <option value="2019">2019</option>
            <option value="2018">2018</option>
          </select>
          <select name="endmonth" id="endmonth">
            <?for($i=1;$i<=12;$i++):?>
              <option value="<?=date("m", strtotime("2016-$i-01"))?>"<?=(date("n") == $i) ? " selected" : ""?>><?=date("M", strtotime("2016-$i-01"))?></option>
            <?endfor?>
          </select>
          <select name="endday" id="endday">
            <?for($i=1;$i<=31;$i++):?>
              <option value="<?=date("d", strtotime("2016-01-$i"))?>"<?=(date("j") == $i) ? " selected" : ""?>><?=date("d", strtotime("2016-01-$i"))?></option>
            <?endfor?>
          </select>
          <input type="text" name="endtime" id="endtime" value="<?=date("H:i:s")?>" size="8" />
          <input type="text" name="endzone" id="endzone" value="<?=date("P")?>" size="5" />
          <span id="reload"></span>
        </p>

        <p>
          <label for="content">Description</label>
          <textarea name="content" id="content"></textarea>
        </p>

        <p>
          <label for="tags">Tags</label>
          <input type="text" name="tags[string]" id="tags" />
        </p>
        <p>
          <label></label>
          <span>
            <input type="checkbox" value="https://rhiaro.co.uk/tags/travel" name="tags[]" id="travel" /><label for="travel">travel</label>
            <input type="checkbox" value="https://rhiaro.co.uk/tags/transit" name="tags[]" id="transit" /><label for="transit">transit</label>
            <input type="checkbox" value="https://rhiaro.co.uk/tags/bus" name="tags[]" id="bus" /><label for="bus">bus</label>
            <input type="checkbox" value="https://rhiaro.co.uk/tags/train" name="tags[]" id="train" /><label for="train">train</label>
            <input type="checkbox" value="https://rhiaro.co.uk/tags/ferry" name="tags[]" id="ferry" /><label for="ferry">ferry</label>
            <input type="checkbox" value="https://rhiaro.co.uk/tags/tram" name="tags[]" id="tram" /><label for="tram">tram</label>
            <input type="checkbox" value="https://rhiaro.co.uk/tags/metro" name="tags[]" id="metro" /><label for="metro">metro</label>
          </span>
        </p>

        <p>
          <label>Published</label> 
          <select name="year" id="year">
            <option value="2020" selected>2020</option>
            <option value="2019">2019</option>
            <option value="2018">2018</option>
          </select>
          <select name="month" id="month">
            <?for($i=1;$i<=12;$i++):?>
              <option value="<?=date("m", strtotime("2016-$i-01"))?>"<?=(date("n") == $i) ? " selected" : ""?>><?=date("M", strtotime("2016-$i-01"))?></option>
            <?endfor?>
          </select>
          <select name="day" id="day">
            <?for($i=1;$i<=31;$i++):?>
              <option value="<?=date("d", strtotime("2016-01-$i"))?>"<?=(date("j") == $i) ? " selected" : ""?>><?=date("d", strtotime("2016-01-$i"))?></option>
            <?endfor?>
          </select>
          <input type="text" name="time" id="time" value="<?=date("H:i:s")?>" size="8" />
          <input type="text" name="zone" id="zone" value="<?=date("P")?>" size="5" />
          <span id="reload"></span>
        </p>

        <p>
          <input type="submit" name="submit" value="Log" />
        </p>
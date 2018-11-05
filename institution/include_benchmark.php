<?php
// get all benchmarks
$bencharray = array();
$bencharray['inst'] = $_GET['inst'];

foreach($_GET as $key => $value) {
	if (strpos($key, 'benchmark') === 0) {
		$bencharray[$key] = $value;
	}
}
// dedupe benchmarks, in case the same one got added twice
$bencharray = array_unique($bencharray);
?>
 <div class="benchgroup">
	<h4><i class="material-icons">school</i> Primary Institution</h4>
	<select name='inst' id='inst'>
		<option value=""></option>
		<?php
		foreach($allinstitutions as $res) {
			echo "<option value='" . $res['Inst_abbrev'] . "'>" . $res['Institution'] . "</option>";
		}
		?>
	</select>
							
	<h4><i class="material-icons">people</i> Benchmarks</h4>
								
	<select id='benchmarks'>
		<option value=""></option>
		<?php
		foreach($allinstitutions as $res) {
			echo "<option value='" . $res['Inst_abbrev'] . "'>" . substr($res['Institution'], 0, 50) . "</option>";
		}
		?>
	</select>
    <input type="button" class="btn btn-local btn-sm"  value="Add" id="addbench"> <input type="button"   class="btn btn-local btn-sm"  id="clearbench" value="Clear"> 

<div id="benchmarklist" class="list-group">
	<?php
    $j = 0;
    if (isset($_GET['inst'])) {
        foreach($bencharray as $key => $value) {
            if (strpos($key, 'inst') === false) {
                $j++;
                echo '<label id="b' . $j . '" class="list-group-item list-group-item-light list-group-item-added"><input type="checkbox" name="benchmark' . $j . '" value="' . $value . '" checked>' . $institutionarray[$value] . '</label>';
            }
        }
    }
    for ($ji = $j + 1; $ji <= 4; $ji++) {
        echo '<label id="b' . $ji . '" class="list-group-item list-group-item-light">No benchmark selected</label>';
    }
    ?>
</div>
<input type="button" class="btn btn-local btn-sm"  id="reloadbench" value="Reload Data" onclick="reload()">		
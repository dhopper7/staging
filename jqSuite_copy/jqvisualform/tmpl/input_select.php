<?php
require_once '../../../jqSuite/jqvisualform/lang/info_en_GB.inc';
?>

<form id="input_text">
	<table style="table-layout: auto;width:600px;">
		<tbody>
		<tr>
			<td style="height:0px;width:35%"></td>
			<td style="height:0px"></td>
			<td style="height:0px"></td>
		</tr>
		<tr>
			<td colspan="3" style="">
				<div class="ui-state-default ui-corner-all" style="padding:6px;">
					<span class="ui-icon ui-icon-triangle-1-s" id="showother" style="float:left; margin:-2px 5px 0 0;cursor:pointer;" title="Hide Select Properties"></span>
					Select  Properties
				</div>
			</td>
		</tr>
		<tr class="otherparam">
			<td style="width:35%;">
				<label for="label"> Label </label>
			</td>
			<td>
				<input type="text" id="label" name="label" style="width:98%;" maxlength="100" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $label?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="disabled"> Disabled </label>
			</td>
			<td>
				<input type="checkbox" id="disabled" name="disabled" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $disabled?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="form"> Form ID </label>
			</td>
			<td>
				<input type="text" id="form"  name="form" style="width:98%;" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $form?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="size"> Size </label>
			</td>
			<td>
				<input type="text" id="size" style="width:98%;" name="size" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $size2?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="multiple"> Multiple </label>
			</td>
			<td>
				<select id="multiple" name="multiple" class="ui-widget-content ui-corner-all select-ui"><option value="">Select</option><option value="multiple">Multiple</option></select>
			</td>
			<td class="help" title="<?php echo $multiple?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="autofocus"> Autofocus </label>
			</td>
			<td>
				<input type="checkbox" id="autofocus" name="autofocus" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $autofocus?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="required"> Required  </label>
			</td>
			<td>
				<input type="checkbox" id="required" name="required" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $required?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="datalist"> Data List  </label>
			</td>
			<td>
				<input type="text" id="datalist" style="width:98%;" name="datalist" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $datalist?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr class="otherparam">
			<td>
				<label for="datasql"> Data SQL  </label>
			</td>
			<td>
				<input type="text" id="datasql" style="width:98%;" name="datasql" class="ui-widget-content ui-corner-all input-ui"/>
			</td>
			<td class="help" title="<?php echo $datasql?>"><span class='ui-icon ui-icon-info'></span></td>
		</tr>
		<tr>
			<td colspan="3" style="">
				<div class="ui-state-default ui-corner-all" style="padding:6px;">
					<span class="ui-icon ui-icon-triangle-1-e" id="showglob" style="float:left; margin:-2px 5px 0 0;cursor:pointer;" title="Show Global Attributes"></span>
					Global Attributes
				</div>
			</td>
		</tr>
		<?php include '../../../jqSuite/jqvisualform/tmpl/global_attr.inc';?>

		</tbody>
	</table>
</form>
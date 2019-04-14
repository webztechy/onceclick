<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<table cellpadding="5">
	<tr><td style="text-align:center">RECEIPT INFO</td></tr>
	<tr><td style="text-align:center">No. <?php echo $receipt_code; ?></td></tr>
	<tr><td style="text-align:center">Date. <?php echo $receipt_created_date; ?></td></tr>
</table>
<p>&nbsp;</p>
<table border="1"  cellpadding="5">
	<tr>
		<td style="text-align:center">ITEM</td>
		<td style="text-align:center">NAME</td>
		<td style="text-align:center">VAT</td>
		<td style="text-align:center">PRICE</td>
		<td style="text-align:center">TOTAL</td>
	</tr>
	<?php
	foreach($product_items as $product_subtitems){
		foreach($product_subtitems as $srow){
	?>
	<tr>
		<td style="text-align:center"><?php echo $srow['product_barcode']; ?></td>
		<td><?php echo $srow['product_name']; ?></td>
		<td style="text-align:center"><?php echo $srow['product_vat']; ?></td>
		<td style="text-align:center"><?php echo $srow['product_cost']; ?></td>
		<td style="text-align:center"><?php echo $srow['product_total']; ?></td>
	</tr>
		<?php } ?>
	<?php } ?>
	
	<tr>
		<td style="text-align:right" colspan="4">TOTAL</td>
		<td style="text-align:right"><?php echo $receipt_total; ?></td>
	</tr>

	
</table>

	
<legend>Update <?php echo $item['name']?></legend>
<?php
   
echo form_open('admin/update/'.$item['barcode']);

echo form_input('name', set_value('name', $item['name']));
echo form_input('brand', set_value('brand', $item['brand']));
echo form_input('category', set_value('category', $item['category']));
echo form_input('price', set_value('price', $item['price']));
echo form_input('quantity', set_value('quantity', $item['quantity']));
echo form_input('size', set_value('size', $item['i_size']));
echo form_input('colour', set_value('colour', $item['i_colour']));
echo form_textarea('description', set_value('description', $item['description']),50,100);
echo form_submit('submit', 'Update');
?>
</fieldset>

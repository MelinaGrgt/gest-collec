<?php
if(isset($cart)) { ?>
 <table class="table table-bordered table-striped table-hover">
     <thead>
         <tr>
            <th>ID</th>
            <th>NAME</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
     </thead>
     <tbody>
        <?php foreach($cart['items'] as $item) { ?>
        <tr>
            <td><?=$item['id'];?></td>
            <td><?=$item['name'];?></td>
            <td><?=$item['quantity'];?></td>
            <td><?=$item['price'];?></td>
        </tr>
     <?php } ?>
     </tbody>
     <tfoot>
     <tr>
         <td colspan="2">Total</td>
         <td><?=$cart['count'];?></td>
         <td><?=$cart['total'];?></td>
     </tr>
     </tfoot>
 </table>
<?php }  else {
    echo "Votre panier est vide";
}?>
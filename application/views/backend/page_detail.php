<?php require_once("common/header.php");
foreach($showpagecontent as $page):
?>
    <div class="fullcontent right clear">
     <div class="dev-col-1 colbg">
        <h1>Page Detail (<?php echo $page->pHeading; ?>)</h1>
        <table width="100%" class="detailspage" border="0" cellspacing="0" cellpadding="0">
          <thead>
            <tr>
              <th>Page Heading</th>
              <td><?php echo $page->pHeading; ?></td>
              </tr>
            <tr>
              <th>Page Meta Title</th>
              <td><?php echo $page->pTitle; ?></td>
            </tr>
            <tr>
              <th>Page Meta Description</th>
              <td><?php echo $page->pDescp; ?></td>
            </tr>
            <tr>
              <th>Page Meta Keywords</th>
              <td><?php echo $page->pKeyword; ?></td>
            </tr>
            <tr>
              <th>Page Link</th>
              <td><?php echo $page->pLink; ?></td>
            </tr>
            <tr>
              <th>Page Content</th>
              <td><?php echo $page->pContent; ?></td>
            </tr>
            <tr>
              <th>Status</th>
              <td><?php if($page->pStatus == '1'){echo 'Active';} else { echo '<span style="color:#f00;">In-Active</span>';} ?></td>
            </tr>
            <tr>
              <th>&nbsp;</th>
              <td><a href="<?php echo base_url(); ?>backend/edit/page?type=edit&pID=<?php echo $page->pID; ?>"><i class="fa fa-pencil-square-o left coloredit"></i></a> &nbsp;&nbsp;Edit page</td>
            </tr>
          </thead>
<?php
endforeach;
?>   
        </table>
      </div>
    </div>
    <?php require_once("common/footer.php"); ?>
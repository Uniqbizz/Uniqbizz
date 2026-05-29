<?php

    $user_id=$id;
    $table = getUserTable($user_type);

?>
<span class="edit-log-tooltip text-info"
      data-user="<?=$user_id?>"
      data-table="<?=$table?>"
      data-column="<?=$column?>"
      data-bs-toggle="tooltip"
      title="No changes!"
      style="cursor:pointer;">
      <i class="mdi mdi-history"></i>
</span>

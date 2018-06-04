<?php
/**
 * Filename: Base
 * Description: Contains all atomics
 * Pre-Requisits: ess/base.php
 */
class Internal_Post extends internal
{
  public function get_post($link, $data){
    $section_ext_id = !isset($data->section_id)?0:$data->section_id;
    $section_id = parent::int_id($section_ext_id);
    $page = !isset($data->page)?0:$data->page;

    $limit = 15;
    $start = $page * $limit;
    $end = $start + $limit;
    $next = $page + 1;
    $prev = $page != 0?$page - 1:$page;

    $sql = "SELECT uiu_id, user_id, post_id, section_id, post, time_stamp, dp, CONCAT_WS(' ', firstname, middlename, lastname) AS name
            FROM post NATURAL JOIN user_info NATURAL JOIN member
            WHERE section_id='".$section_id."' ORDER BY time_stamp DESC LIMIT ". $start .",". $end . "";

    if(isset($data->post_id)){
      $post_ext_id = $data->post_id;
      $post_id = parent::int_id($post_ext_id);
      $sql = "SELECT uiu_id, user_id, post_id, section_id, post, time_stamp, dp, CONCAT_WS(' ', firstname, middlename, lastname) AS name
              FROM post NATURAL JOIN user_info NATURAL JOIN member
              WHERE post_id='".$post_id."'";
    }

    if(isset($data->news_feed) || isset($data->notification)){
      $post_ext_id = $data->post_id;
      $post_id = parent::int_id($post_ext_id);
      $sql = "SELECT uiu_id, user_id, post_id, section_id, post, time_stamp, dp, CONCAT_WS(' ', firstname, middlename, lastname) AS name,
                    CONCAT_WS(' - ', course_code, section_name) AS course_name
              FROM post NATURAL JOIN user_info NATURAL JOIN section NATURAL JOIN member
              WHERE post_id='".$post_id."'";
    }

    $result = $link->query($sql);
    if($result->num_rows <= 0){
      echo "No Posts!";
      if(!isset($data->post_id))
        $next = $page;
    }

    while($post = $result->fetch_assoc()){
      $post_data["post_id"] = parent::ext_id($post["post_id"]);
      $target_ajax = "comment_" . $post_data['post_id'];
      $profile_link = parent::profile_link($post["uiu_id"], parent::user_ext_id($post["user_id"]));
      $comment_count = "SELECT count(comment_id) as cid
                        FROM comment
                        WHERE post_id='".$post["post_id"]."'";
      $comment_count = $link->query($comment_count);
      $comment_count = $comment_count->fetch_assoc();
      $comment_count = $comment_count["cid"];
      ?>
      <div class="media">
        <div class="media-left">
          <a href="<?php echo $profile_link ?>">
            <?php echo parent::display_picture($post["dp"], $post["name"], "thumb-small"); ?>
          </a>
        </div>
        <div class="media-body">
          <h4 class="media-heading">
            <?php
              echo '<a href="'.$profile_link.'">'.$post['name'].'</a>';
              if(isset($data->news_feed)){
                $course_link = parent::get_host() . "section.php?id=" . parent::ext_id($post['section_id']);
                echo ' > <a href="'.$course_link.'">'.$post['course_name'].'</a>';
              }else if(isset($data->notification)){
                $course_link = parent::get_host() . "section.php?id=" . parent::ext_id($post['section_id']);
                echo ' posted in <a href="'.$course_link.'">'.$post['course_name'].'</a>';
              }
            ?>
          </h4>
          <p><?php echo nl2br($post['post']) ?></p>
          <p>
            <?php
            if(!isset($data->notification)){
            ?>
            <a href="#<?php echo $target_ajax ?>" id="<?php echo $target_ajax ?>" class="ajaxModalView" titleAjax="Post" linkAjax="internal/section/post.php" data="<?php echo parent::jsonencode($post_data) ?>" >
              Comments (<?php echo $comment_count ?>)
            </a>
            <?php
            }
            ?>
            <small class="text-muted"><?php echo parent::view_time($post['time_stamp']) ?></small>
          </p>
          <?php

          if(isset($data->post_id) && !isset($data->news_feed) && !isset($data->notification)){
          ?>
          <div class="alert alert-warning">
            <?php if(parent::post_permission($link, $post['section_id']) > 0){ ?>
            <form id="comment_form" targetAjax="#comment-block-ajax" class="form-horizontal" role="form" action="actions/section/comment.php" method="post">
              <div class="form-group">
                <div class="panel-heading">
                  <textarea id="comment-input" name="comment" class="form-control" rows="1" cols="70" placeholder="Say something about this post.."></textarea>
                </div>
              </div>
              <div class="panel-footer">
                <input type="hidden" name="post_id" value="<?php echo $post_ext_id ?>">
                <button type="submit" class="btn btn-default pull-right">Comment</button>
                  <p>Comment block for this post.</p>
              </div>
            </form>
                  <!--Comments-->
            <?php
          }
            ?>
            <div id="comment-block-ajax"  linkAjax="internal/section/comment.php" data='<?php echo parent::jsonencode($data) ?>'>
              <?php echo parent::loading(); ?>>
            </div>
          </div>
          <?php
        }
        ?>
        </div>
      </div>
      <?php
    }
    if(!isset($data->post_id)){
    ?>
    <nav>
      <ul class="pager">
        <li><a href="<?php echo parent::get_host() . "section.php?id=" . $section_ext_id . "&page=" . $prev ?>">Previous</a></li>
        <li><a href="<?php echo parent::get_host() . "section.php?id=" . $section_ext_id . "&page=" . $next ?>">Next</a></li>
      </ul>
    </nav>
    <?php
    }
  }
}
?>

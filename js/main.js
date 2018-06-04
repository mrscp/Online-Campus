
$(function() {
  function blockAjax(divId, loop = false, faster = 1) {
    $.ajax({
        type:"POST",
        url:$(divId).attr("linkAjax"),
        data: { data: $(divId).attr("data") },
        success: function(response){
          $(divId).html(response);
          if(loop === true){
            setTimeout(function () {
               blockAjax(divId, loop = true);
            }, 10000/faster);
          }
        }
    });
  }

  blockAjax("#default-block-ajax");
  blockAjax("#running-course");
  blockAjax("#section-info");
  blockAjax("#post-block-ajax", true);
  blockAjax("#news-feed-ajax", true);
  blockAjax("#notification-count-block-ajax", true);
  blockAjax("#message-count-block-ajax", true);
  blockAjax("#message-block-ajax", true, 2);

  $("#pnt_menu a").click(function(){
    var id = $(this).attr("id");
    $("#pnt_menu li").removeClass("active");
    $(this).parent().addClass("active");
    $("#pnt_container div").removeClass("show");
    $("#pnt_container div#" + id).addClass("show");
  });
  var hash = window.location.hash.substr(1);
  if (hash !== '') {
    $("#"+hash).click();
  }

  function modalAjax(linkId) {
    $(document).on('click', linkId, function() {
      var title = $(this).attr("titleAjax");
      $('#myModal').modal('show');
      $.ajax({
          type:"POST",
          url:$(this).attr("linkAjax"),
          data: { data: $(this).attr("data") },
          success: function(response){
            $("#myModal .modal-title").html(title);
            $("#myModal .modal-body").html(response);
            if(title == "Post"){
              blockAjax("#comment-block-ajax", true);
            }
          }
      });
    });
  }

  modalAjax("#ajaxModalView");
  modalAjax(".ajaxModalView");

  function formAjax(form) {
    var id = $(form).attr("id");
    var targetAjax = $(form).attr("targetAjax");
    $("#"+id+" button").attr("disabled","disabled");
    $("#"+id+" #alert").removeClass("show alert-danger");
    $("#"+id+" #alert").addClass("hide alert-success");
    $.ajax({
        type:"POST",
        url:$(form).attr("action"),
        data:$(form).serialize(),
        success: function(response){
          response = response.match(/{(.*)?}/g);
          var obj = $.parseJSON(response);
          if(obj.success == ""){
            var html = "<ul>";
            $.each(obj.message, function( index, value ) {
              html += "<li>"+value+"</li>";
            });
            html += "</ul>";
            $("#"+id+" #alert").removeClass("hide alert-danger");
            $("#"+id+" #alert").addClass("show alert-danger");
            $("#"+id+" #alert").html(html);
          }else{
            var html = "<ul><li>"+obj.successMessage+"</li></ul>";
            $("#"+id+" #alert").removeClass("hide alert-danger");
            $("#"+id+" #alert").addClass("show alert-success");
            $("#"+id+" #alert").html(html);

            if (targetAjax !== '') {
              blockAjax(targetAjax);
            }

            if (typeof obj.redirect !== 'undefined') {
                 window.location = obj.redirect;
            }
          }
        }
    });
    $("#"+id+" button").removeAttr("disabled");
  }

  $("#default-form").submit(function(e){
      e.preventDefault();
      formAjax(this);
  });
  $("#add_phone").submit(function(e){
      e.preventDefault();
      formAjax(this);
  });

  $("#post-form").submit(function(e){
      e.preventDefault();
      formAjax(this);
      $("#post-form #post-input").val("");
  });

  $("#pass_update").submit(function(e){
      e.preventDefault();
      formAjax(this);
  });
  $("#info_update").submit(function(e){
      e.preventDefault();
      formAjax(this);
  });

  $(document).on("submit", "#delete", function(e) {
    e.preventDefault();
    formAjax(this);
    $(this).parent().parent().hide();
  });

  $(document).on("submit", "#comment_form", function(e) {
    e.preventDefault();
    formAjax(this);
    $("#comment_form #comment-input").val("");
  });
  $(document).on("submit", "#message-send-form", function(e) {
    e.preventDefault();
    formAjax(this);
    $("#message-send-form #message-input").val("");
  });
});

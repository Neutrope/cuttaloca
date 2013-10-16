$(function(){
  /* 開く・閉じる*/
  // $("ul.menu").hide();
  $("ul.a1").hide();

  $("#a1 #a1_t").hover(function(){
    $("#a1_b img").css('opacity', '0.4');
        },function(){
    $("#a1_b img").css('opacity', '1');
  });

  $("#a1 #a1_t").click(function(){
    $(this).next().slideToggle('fast');
  });

  $("#a1 #a1_t").toggle(function(){
    $("#a1_b img").attr("src", "img/howto/n1_on.png");
    },function(){
    $("#a1_b img").attr("src", "img/howto/n1_off.png");
  });

  $("#a1 #a1_b").hover(function(){
    $("#a1_t img").css('opacity', '0.4');
        },function(){
    $("#a1_t img").css('opacity', '1');
  });

  $("#a1_b").click(function(){
    $(".a1").slideToggle('fast')
  });

    $("#a1 #a1_b").toggle(function(){
    $("#a1_b img").attr("src", "img/howto/n1_on.png");
    },function(){
    $("#a1_b img").attr("src", "img/howto/n1_off.png");
  });
});


$(function(){
  $("ul.a2").hide();

  $("#a2 #a2_t").hover(function(){
    $("#a2_b img").css('opacity', '0.4');
        },function(){
    $("#a2_b img").css('opacity', '1');
  });

  $("#a2 #a2_t").click(function(){
    $(this).next().slideToggle('fast');
  });

  $("#a2 #a2_t").toggle(function(){
    $("#a2_b img").attr("src", "img/howto/n2_on.png");
    },function(){
    $("#a2_b img").attr("src", "img/howto/n2_off.png");
  });

  $("#a2 #a2_b").hover(function(){
    $("#a2_t img").css('opacity', '0.4');
        },function(){
    $("#a2_t img").css('opacity', '1');
  });

  $("#a2_b").click(function(){
    $(".a2").slideToggle('fast')
  });

    $("#a2 #a2_b").toggle(function(){
    $("#a2_b img").attr("src", "img/howto/n2_on.png");
    },function(){
    $("#a2_b img").attr("src", "img/howto/n2_off.png");
  });
});



$(function(){
  $("ul.a3").hide();

  $("#a3 #a3_t").hover(function(){
    $("#a3_b img").css('opacity', '0.4');
        },function(){
    $("#a3_b img").css('opacity', '1');
  });

  $("#a3 #a3_t").click(function(){
    $(this).next().slideToggle('fast');
  });

  $("#a3 #a3_t").toggle(function(){
    $("#a3_b img").attr("src", "img/howto/n3_on.png");
    },function(){
    $("#a3_b img").attr("src", "img/howto/n3_off.png");
  });

  $("#a3 #a3_b").hover(function(){
    $("#a3_t img").css('opacity', '0.4');
        },function(){
    $("#a3_t img").css('opacity', '1');
  });

  $("#a3_b").click(function(){
    $(".a3").slideToggle('fast')
  });

    $("#a3 #a3_b").toggle(function(){
    $("#a3_b img").attr("src", "img/howto/n3_on.png");
    },function(){
    $("#a3_b img").attr("src", "img/howto/n3_off.png");
  });
});

$(function(){
  $("ul.a4").hide();

  $("#a4 #a4_t").hover(function(){
    $("#a4_b img").css('opacity', '0.4');
        },function(){
    $("#a4_b img").css('opacity', '1');
  });

  $("#a4 #a4_t").click(function(){
    $(this).next().slideToggle('fast');
  });

  $("#a4 #a4_t").toggle(function(){
    $("#a4_b img").attr("src", "img/howto/n4_on.png");
    },function(){
    $("#a4_b img").attr("src", "img/howto/n4_off.png");
  });

  $("#a4 #a4_b").hover(function(){
    $("#a4_t img").css('opacity', '0.4');
        },function(){
    $("#a4_t img").css('opacity', '1');
  });

  $("#a4_b").click(function(){
    $(".a4").slideToggle('fast')
  });

    $("#a4 #a4_b").toggle(function(){
    $("#a4_b img").attr("src", "img/howto/n4_on.png");
    },function(){
    $("#a4_b img").attr("src", "img/howto/n4_off.png");
  });
});


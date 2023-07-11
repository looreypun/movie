// javascript code for loading animation 
; (function () {
    function id(v) { return document.getElementById(v); }
    function loadbar() {
        var ovrl = id("overlay"),
            prog = id("progress"),
            stat = id("progstat"),
            img = document.images,
            c = 0,
            tot = img.length;
        if (tot == 0) return doneLoading();

        function imgLoaded() {
            c += 1;
            var perc = ((100 / tot * c) << 0) + "%";
            prog.style.width = perc;
            stat.innerHTML = "Loading " + perc;
            if (c === tot) return doneLoading();
        }
        function doneLoading() {
            ovrl.style.opacity = 0;
            setTimeout(function () {
                ovrl.style.display = "none";
            }, 1200);
        }
        for (var i = 0; i < tot; i++) {
            var tImg = new Image();
            tImg.onload = imgLoaded;
            tImg.onerror = imgLoaded;
            tImg.src = img[i].src;
        }
    }
    document.addEventListener('DOMContentLoaded', loadbar, false);
}());

// jquery code for ajax request in index.php

    $('#trendingBtn').click(function(event,index){
    $("#popularBtn").removeClass(".btn btn-dark").addClass(".btn btn-outline-dark");
    $("#trendingBtn").removeClass(".btn btn-outline-dark").addClass(".btn btn-dark");
    $('#link').attr('href','trendingLink');
    $.ajax({
    url:'/trending',
    type:'GET',
    success: function(result) {
        $("#popular").empty();
        jQuery.each(result.data,function(key, value){
        console.log(value);
            $( "#popular" ).append(
            "<div  class='col-6 col-md-3 col-xl-2'>"+
            "<a href='/play/"+value.id+"'><img class='display_img' src='https://image.tmdb.org/t/p/w500"+value.poster_path+"'width='100%'' height='100%'' ></a>"+
            "</div>"
            );
        });
    }});})
    $('#popularBtn').click(function(event,index){
    $("#popularBtn").removeClass(".btn btn-outline-dark").addClass(".btn btn-dark");
    $("#trendingBtn").removeClass(".btn btn-dark").addClass(".btn btn-outline-dark");
    $('#link').attr('href','popularLink');
    $.ajax({
    url:'/popular',
    type:'GET',
    success: function(result) {
        $("#popular").empty();
        jQuery.each(result.data,function(key, value){
        console.log(value);
            $( "#popular" ).append(
            "<div  class='col-6 col-md-3 col-xl-2'>"+
            "<a href='/play/"+value.id+"'><img class='display_img' src='https://image.tmdb.org/t/p/w500"+value.poster_path+"'width='100%'' height='100%'' ></a>"+
            "</div>"
            );
        });
    }});})

    $('#commingSoonBtn').click(function(event,index){
    $("#latestBtn").removeClass(".btn btn-dark").addClass(".btn btn-outline-dark");
    $("#commingSoonBtn").removeClass(".btn btn-outline-dark").addClass(".btn btn-dark");
    $('#down-link').attr('href','upcomingLink');
    $.ajax({
    url:'/commingSoon',
    type:'GET',
    success: function(result) {
        $("#now-playing").empty();
        jQuery.each(result.data,function(key, value){
        console.log(value);
            $( "#now-playing" ).append(
            "<div class='col-6 col-md-3 col-xl-2'>"+
            "<a href='/play/"+value.id+"'><img class='display_img' src='https://image.tmdb.org/t/p/w500"+value.poster_path+"'width='100%'' height='100%'' ></a>"+
            "</div>"
            );
        });
    }});})
    $('#latestBtn').click(function(event,index){
    $("#commingSoonBtn").removeClass(".btn btn-dark").addClass(".btn btn-outline-dark");
    $("#latestBtn").removeClass(".btn btn-outline-dark").addClass(".btn btn-dark");
    $('#down-link').attr('href','latestLink');
    $.ajax({
    url:'/latest',
    type:'GET',
    success: function(result) {
        $("#now-playing").empty();
        jQuery.each(result.data,function(key, value){
        console.log(value);
            $( "#now-playing" ).append(
            "<div class='col-6 col-md-3 col-xl-2'>"+
            "<a href='/play/"+value.id+"'><img class='display_img' src='https://image.tmdb.org/t/p/w500"+value.poster_path+"'width='100%'' height='100%'' ></a>"+
            "</div>"
            );
        });
    }});})


// day night mode jquery code
$("#nightbutton").click(function(){
  $("#light-div").addClass("d-none");
  $("#dark-div").removeClass("d-none");
  $("body").css('backgroundColor','black');
  $(".panel-heading").addClass("text-light");
});
$("#daybutton").click(function(){
  $("#light-div").removeClass("d-none");
  $("#dark-div").addClass("d-none");
  $("body").css('backgroundColor','white');
  $(".panel-heading").removeClass("text-light");
});


// ad pop up on video click 
if($("#video-play").hasClass("advertisement")){
    $("#video-play").click(function(){
        $(this).removeClass('advertisement');
        window.open('www.google.com');
})};

$("#grid").click(function(){
    $("#list-view").addClass("d-none");
    $("#grid-view").removeClass("d-none");
})
$("#list").click(function(){
    $("#grid-view").addClass("d-none");
    $("#list-view").removeClass("d-none");
})
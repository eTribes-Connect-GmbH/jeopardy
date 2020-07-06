import $ from 'jquery';

$(document).ready(function () {
    $('.js-example-basic-single').select2();
});

const cardWidth = $('.filter-card-group .entry').width() + 10;
$(".btn-left").click(function () {
    let leftPos = $('.filter-card-group').scrollLeft();
    $(".filter-card-group").animate({scrollLeft: leftPos - cardWidth}, 400);
});

$(".btn-right").click(function () {
    let leftPos = $('.filter-card-group').scrollLeft();
    $(".filter-card-group").animate({scrollLeft: leftPos + cardWidth}, 400);
});
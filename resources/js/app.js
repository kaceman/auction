import './bootstrap';

import Alpine from 'alpinejs';

import $ from 'jquery';
import moment from 'moment';

import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';
import 'slick-carousel';

window.moment = moment;
window.$ = $;

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function() {
    $("#status-message").fadeOut(3000);


    $(".open-modal").on('click', function() {
        const price = $(this).attr('data-min-price');
        const articleId = $(this).attr('data-article-id');
        const modal = $('#bid-modal');
        modal.toggleClass('hidden');
        modal.find('input').val(price)
        modal.find('input').attr('min', price)
        modal.find('input').attr('data-article-id', articleId)
    });

    $(".cancelBid").on('click', function() {
        const modal = $('#bid-modal');
        modal.toggleClass('hidden');
    });

    $(document).on('click', '.bid', function() {
        const modal = $('#bid-modal');
        const input = modal.find('input');
        const val = input.val();
        const articleId = input.data('articleId');
        const data = { bid_price: val, article_id: articleId }
        $.ajax({
            type: "POST",
            url: "/articles/bid",
            data: JSON.stringify(data),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    $('#article-id-' + response.articleId).find('.bid-value').text(response.bidPrice + ' DHs');
                    $('#article-id-' + response.articleId).find('.open-modal').attr('data-min-price', response.bidPrice);
                }
                modal.toggleClass('hidden');
            }
        });
    });

    $('.carousel').slick({
        dots: true, // this will show the dot indicators
        arrows: false, // this will hide the navigation arrows
        autoplay: true, // this will make the carousel auto play
        autoplaySpeed:3000, // this will set the speed of auto play
    });

    const statusCheckbox = document.getElementById("status-checkbox");
    const statusButton = document.getElementById("status-button");

    statusCheckbox.addEventListener("change", function () {
        if (this.checked) {
            statusButton.classList.add("active");
        } else {
            statusButton.classList.remove("active");
        }

        $.ajax({
            type: "POST",
            url: "/admin/articles/status/" + statusCheckbox.getAttribute('data-article-id'),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

});

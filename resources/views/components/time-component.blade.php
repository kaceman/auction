<div id="countdown{{$articleId}}"></div>

<script>
    const x = setInterval(function() {
        var now = moment();
        var end = moment('{{$time}}');
        var duration = moment.duration(end.diff(now));

        $('#countdown{{$articleId}}').html(duration.days() + "d " + duration.hours() + "h " + duration.minutes() + "m " + duration.seconds() + "s ");
        if (now > end) {
            $('#countdown{{$articleId}}').html('EXPIRED');
            $('#article-id-{{$articleId}}').find('.open-modal').hide();
            clearInterval(x);
        }
    }, 1000);
</script>

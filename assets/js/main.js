;(function($, window, document, undefined) {
    'use strict';

    $(() => {
        $('.happymap').each((index, map) => {
            const $map = $(map);
            const $iframe = $('<iframe>');
            const lat = $map.attr('data-lat');
            const long = $map.attr('data-long');

            $iframe.attr({
                'src': `https://maps.google.com/maps?q=${lat},${long}&hl=en&output=embed`,
                'frameborder': 0,
                'allowfullscreen': '',
                'loading': 'lazy'
            });

            $map.append($iframe);
        });
    });
})(jQuery, window, document);
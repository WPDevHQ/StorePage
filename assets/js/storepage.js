jQuery(function( $ ){

    var home_featured = [[0, 16], [100, 0], [100, 84], [0, 100]];
    $('.storepage-content').clipPath(home_featured, {
        isPercentage: true,
        svgDefId: 'storepage-content'
    });
 
});
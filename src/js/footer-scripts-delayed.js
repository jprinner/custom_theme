//Invoca Code for https://www.highspeedoptions.com
(function(i,n,v,o,c,a) { i.InvocaTagId = o; var s = n.createElement('script'); s.type = 'text/javascript';s.async = true; s.src = ('https:' === n.location.protocol ? 'https://' : 'http://' ) + v;var fs = n.getElementsByTagName('script')[0]; fs.parentNode.insertBefore(s, fs);})(window, document, 'solutions.invocacdn.com/js/invoca-latest.min.js', '1886/3934625857');

addGclidToInternalLinks();
populateAffClickID();

$('.provider-more-info .collapse').on('show.bs.collapse', function() {
  var view = $(this).parent();
  view.find('.detail-text').text('Hide Details');
  view.find('.material-icons').css('transform', 'rotate(0deg)')
  
});
$('.provider-more-info .collapse').on('hide.bs.collapse', function() {
  var view = $(this).parent();
  view.find('.detail-text').text('View Details');
  view.find('.material-icons').css('transform', 'rotate(180deg)')
});

<!-- Clearapp code start -->
<script>
(function(){window.Clearapp=window.Clearapp||{};window.Clearapp.queue=window.Clearapp.queue||[];var methods=["set","on","trigger"];var factory=function(method){return function(){Clearapp.queue.push([method].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<methods.length;i++){Clearapp[methods[i]]=factory(methods[i])}})();
Clearapp.set(<?php echo $data_layer ?>);
</script>
<script src="//cdn.clearapp.net/js/<?php echo $container_id ?>.js"></script>
<!-- Clearapp code end -->


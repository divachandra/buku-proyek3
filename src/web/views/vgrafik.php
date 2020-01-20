<!DOCTYPE html>
<html>
<head>
	<title>Grafik Aktivitas Mahasiswa</title>

	<?php
        foreach($jan as $data){
            $jumlahjanuary[] = $data->kegiatan;
        }
        foreach($feb as $data){
            $jumlahfebruary[] = $data->kegiatan;
        }
        foreach($mar as $data){
            $jumlahmarch[] = $data->kegiatan;
        }
        foreach($apr as $data){
            $jumlahapril[] = $data->kegiatan;
        }
        foreach($may as $data){
            $jumlahmay[] = $data->kegiatan;
        }
        foreach($jun as $data){
            $jumlahjune[] = $data->kegiatan;
        }
        foreach($jul as $data){
            $jumlahjuly[] = $data->kegiatan;
        }
        foreach($aug as $data){
            $jumlahaugust[] = $data->kegiatan;
        }
        foreach($sep as $data){
            $jumlahseptember[] = $data->kegiatan;
        }
        foreach($oct as $data){
            $jumlahoctober[] = $data->kegiatan;
        }
        foreach($nov as $data){
            $jumlahnovember[] = $data->kegiatan;
        }
        foreach($dec as $data){
            $jumlahdecember[] = $data->kegiatan;
        }
    ?>
</head>
<body>

	<canvas id="canvas" width="1000" height="280"></canvas>

	<!--Load chart js-->
	<script type="text/javascript" src="<?php echo base_url().'assets/js/Chart.min.js'?>"></script>
	<script>

            var lineChartData = {
                labels : ["January","February","March","April","May","June","July","August","September","October","November","December"],
                datasets : [
                    
                    {
                        fillColor: "rgba(60,141,188,0.9)",
                        strokeColor: "rgba(60,141,188,0.8)",
                        pointColor: "#3b8bba",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(152,235,239,1)",
                        data : [<?php echo json_encode($jumlahjanuary);?>,<?php echo json_encode($jumlahfebruary);?>,<?php echo json_encode($jumlahmarch);?>,<?php echo json_encode($jumlahapril);?>,<?php echo json_encode($jumlahmay);?>,<?php echo json_encode($jumlahjune);?>,<?php echo json_encode($jumlahjuly);?>,<?php echo json_encode($jumlahaugust);?>,<?php echo json_encode($jumlahseptember);?>,<?php echo json_encode($jumlahoctober);?>,<?php echo json_encode($jumlahnovember);?>,<?php echo json_encode($jumlahdecember);?>]
                    }

                ]
                
            }

        var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData);
        
   	</script>
</body>
</html>
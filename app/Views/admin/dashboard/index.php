<div class="row row-cols-3">
    <div class="col">
        <div class="card">
            <div class="card-header text-center">
                <div class="card-title">Total des Utilisateurs :<?php
                    $totalUsers = array_sum(array_column($infosUser, 'count'));?>
                    <?= $totalUsers ?>
                </div>
            </div>
            <div class="card-body">
                <canvas id="userPieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    //convertir le tableau php en un object javascript
    var data = <?php echo json_encode($infosUser); ?>;

    //extraire les labels(noms) et les données (counts) pour le graphique
    var labels = data.map(function(item) {
        return item.name;
    });

    var counts = data.map(function (item) {
        return item.count;
    });

    //Configuration du graphique en secteurs

    var ctx = document.getElementById('userPieChart').getContext('2d');
    var myPieChart = new Chart(ctx,{
        type:'pie',
        data: {
            labels:labels,
            datasets: [{
                data: counts,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            }
        }
    });
</script>

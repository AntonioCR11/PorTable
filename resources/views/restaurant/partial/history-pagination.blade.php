@php
    if ($page - 2 >= 1 && $page + 2 <= $paginationSize) {
        for ($i = $page - 2; $i <= $page + 2; $i++) {
            if ($i != $page) {
                echo "<button page='$i' class='btn btn-secondary'>$i</button>";
            }
            else {
                echo "<button page='$i' class='btn btn-info'>$i</button>";
            }
        }
    }
    else if ($page - 2 < 1) {
        for ($i = 1; $i <= min($paginationSize, 5); $i++) {
            if ($i != $page) {
                echo "<button page='$i' class='btn btn-secondary'>$i</button>";
            }
            else {
                echo "<button page='$i' class='btn btn-info'>$i</button>";
            }
        }
    }
    else  {
        for ($i = $paginationSize - 4; $i <= $paginationSize; $i++) {
            if ($i != $page) {
                echo "<button page='$i' class='btn btn-secondary'>$i</button>";
            }
            else {
                echo "<button page='$i' class='btn btn-info'>$i</button>";
            }
        }
    }
@endphp

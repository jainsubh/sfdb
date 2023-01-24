@if(isset($results))
    @foreach ($results as $result)
        <article class="panel module">
        <span class="head text">
            <?php 
                $data = (array) $result;
            ?> 
            <a href="<?= $data["link"] ?>" target="_blank"><?= $data['link'] ?></a>
        </span>
        <span class="title text"> <a href="<?= $data["link"] ?>" target="_blank"><?= $data['title'] ?></a> </span>
        <span class="text description"> <p><?= (isset($data["snippet"])?$data["snippet"]:'') ?></p></span>
        </article>
    @endforeach
@endif
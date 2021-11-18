<div class="list">
    <section>
        <div class="message">

            <?php

            // dump($params['error']);

            if (!empty($params['error'])) {

                switch ($params['error']) {
                    case 'missingNoteId':
                        echo 'Niepoprawny identyfikator notatki';
                        break;
                    case 'noteNotFound':
                        echo 'Notatka nie została znaleziona';
                        break;
                }
            }
            ?>
        </div>
        <div class="message">
            <?php

            if (!empty($params['before'])) {
                switch ($params['before']) {
                    case 'created':
                        echo 'Notatka zostało utworzona';
                        break;
                    case 'edit':
                        echo 'Notatka zostało zaktualizowana';
                        break;
                    case 'delete':
                        echo 'Notatka zostało usunieta';
                        break;
                }
            }
            ?>
        </div>

        <?php 
            $settings= $params['settings'];
            $sortby = $settings['sortby'];
            $orderby = $settings['orderby'];            
        ?>
    
        
        <form action="/" method="GET">
            <div>
                <span>Sortuj po: </span>
                <div>
                    <label >Tytule<input type="radio" name="sortby" value="title" <?php  echo $sortby === "title" ? 'checked' : ''?>></label>
                    <label >Dacie<input type="radio" name="sortby" value="created" <?php  echo $sortby === "created" ? 'checked' : ''?>></label>
                </div>                
            </div>
            <div>
                <span>Kierunek sortowania: </span>
                <div>
                    <label >Rosnąco<input type="radio" name="orderby" value="asc" <?php  echo $orderby === "asc" ? 'checked' : ''?>></label>
                    <label >Malejąco<input type="radio" name="orderby" value="desc" <?php  echo $orderby === "desc" ? 'checked' : ''?>></label>
                </div>                
            </div>
            <input type="submit" value="sortuj">
        </form>

        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tytuł</th>
                        <th>opis</th>
                        <th>Data</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <?php foreach ($params['notes'] as $note) : ?>
                <tr>
                    <td><?php echo $note['id'] ?></td>
                    <td><?php echo htmlentities($note['title']) ?></td>
                    <td><?php echo htmlentities($note['description']) ?></td>
                    <td><?php echo htmlentities($note['created']) ?></td>
                    <td>
                        <a href="/?action=show&id=<?php echo (int) $note['id'] ?>">
                            <button>Zobacz</button>
                        </a>
                        <a href="/?action=delete&id=<?php echo (int) $note['id'] ?>">
                            <button>usun</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
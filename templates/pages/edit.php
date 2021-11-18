<?php $note = $params['note']; ?>
<?php if ($note) : ?>
<form action="/?action=edit" method="post">
    <ul>
        <li>
            <input hidden type="text" name='id' class='field-long' id='field4' value='<?php echo  $note['id'] ?>'>
        </li>
        <li>
            <label for='field4'>Tytuł</label>
            <input type="text" name='title' class='field-long' id='field4' value='<?php echo  $note['title'] ?>'>
        </li>
        <li>
            <label for='field5'>Opis</label>
            <textarea name="description" id="field5"
                class='field-long field-textarea'><?php echo  $note['description'] ?></textarea>
        </li>
        <li>
            <input type="submit" value="edytuj">
        </li>
    </ul>
    <?php else : ?>
    <div>Brak danych o notatce</div>
    <?php endif  ?>
</form>
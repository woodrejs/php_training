<div>
    <?php $note = $params['note'] ?? null ?>
    <?php if ($note) : ?>
    <ul>
        <li><?php echo $note['id'] ?></li>
        <li><?php echo htmlentities($note['title']) ?></li>
        <li><?php echo htmlentities($note['description']) ?></li>
        <li><?php echo htmlentities($note['created']) ?></li>
    </ul>
    <?php else : ?>
    <div>Brak notatki do wyświetlenia</div>
    <?php endif ?>
    <form action="/?action=delete" method="post">
        <input type="text" name='id' hidden value="<?php echo $note['id'] ?>">
        <input type="submit" value="usun">
    </form>
    <a href="/?action=edit&id=<?php echo $note['id'] ?>">
        <button>Edycja</button>
    </a>
    <a href="/">
        <button>Powrót</button>
    </a>
</div>
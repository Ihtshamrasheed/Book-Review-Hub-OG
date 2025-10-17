<?php

function getBooks(PDO $pdo, array $filters = []): array
{
    $query = "SELECT b.*, r.Rating AS user_rating, w.Book_ID AS in_wishlist
              FROM book b
              LEFT JOIN rating r ON b.Book_ID = r.Book_ID AND r.Person_ID = :user_id
              LEFT JOIN wishlist w ON b.Book_ID = w.Book_ID AND w.Person_ID = :user_id";

    $conditions = [];
    $params = [':user_id' => $_SESSION['user_id'] ?? 0];

    if (!empty($filters['search'])) {
        $conditions[] = "(b.Title LIKE :search OR b.Author LIKE :search OR b.Description LIKE :search)";
        $params[':search'] = "%{$filters['search']}%";
    }

    if (!empty($filters['genres'])) {
        $genrePlaceholders = [];
        foreach ($filters['genres'] as $key => $genre) {
            $placeholder = ":genre{$key}";
            $genrePlaceholders[] = "b.Genre LIKE {$placeholder}";
            $params[$placeholder] = "%{$genre}%";
        }
        if (!empty($genrePlaceholders)) {
            $conditions[] = '(' . implode(' OR ', $genrePlaceholders) . ')';
        }
    }

    if (!empty($conditions)) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }

    $sortOptions = [
        'Title_asc' => 'b.Title ASC',
        'Title_desc' => 'b.Title DESC',
        'Author_asc' => 'b.Author ASC',
        'Author_desc' => 'b.Author DESC',
        'Book_ID_asc' => 'b.Book_ID ASC',
        'Book_ID_desc' => 'b.Book_ID DESC',
        'Rating_asc' => 'b.Curr_rating ASC',
        'Rating_desc' => 'b.Curr_rating DESC'
    ];

    $orderClause = $sortOptions[$filters['sort']] ?? 'b.Title ASC';
    $query .= " ORDER BY {$orderClause}";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll();
}
?>
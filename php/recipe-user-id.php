<?php

/**
 * gets all recipes
 *
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray SplFixedArray of recipes found or null if not found
 *
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
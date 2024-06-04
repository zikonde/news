<?php

function calculateTrendingScore($newsData) {
    /*
    Calculates a trending score for a news item based on factors.

    Args:
        $newsData: An associative array containing news details.
            - title (string): Title of the news.
            - published_date (DateTime): Date and time the news was published.
            - views (int): Number of views the news has received.
            - shares (int): Number of times the news has been shared.
            - comments (int): Number of comments on the news.

    Returns:
        A float representing the calculated trending score.
    */

    // Define weights for each factor (adjust as needed)
    $weightViews = 0.4;
    // $weightShares = 0.1;
    $weightComments = 0.35;
    $weightFreshness = 0.25;  // Factor based on news age

    // Calculate time difference in hours since publication
    $currentTime = new DateTime();
    $timeDiff = $currentTime->diff($newsData['published_date']);
    $hoursSincePublished = $timeDiff->h + ($timeDiff->days * 24);

    // Apply decay factor to freshness based on time passed
    $freshnessScore = 1 - ($hoursSincePublished / (24 * 7)); // Decay over a week

    // Calculate score based on weighted factors
    $trendingScore = ($newsData['views'] * $weightViews) + 
                    // ($newsData['shares'] * $weightShares) + 
                    ($newsData['comments'] * $weightComments) + 
                    ($freshnessScore * $weightFreshness);

    return $trendingScore;
}

// Example usage
$newsItem1 = [
  "title" => "Breaking News: Major discovery in science!",
  "published_date" => new DateTime("2024-05-29"),
  "views" => 10000,
  "shares" => 500,
  "comments" => 200,
];

$trendingScore = calculateTrendingScore($newsItem1);

echo "Trending score for news item: " . $trendingScore . PHP_EOL;

?>
<?php
function calculateTrendingScore($newsData) {
    /*
    �������ؼ���������Ŀ�����Ŷȵ÷֡�

    ����:
        $newsData: ������������Ĺ������顣
            - title (string): ���ű��⡣
            - published_date (DateTime): ���ŷ��������ں�ʱ�䡣
            - views (int): �����յ������������
            - shares (int): ���ű�����Ĵ�����
            - comments (int): ���ŵ�����������

    ����:
        һ����ʾ����õ������Ŷȵ÷ֵĸ�������
    */

    // ����ÿ�����ص�Ȩ�أ�������Ҫ���е�����
    $weightViews = 0.4;
    // $weightShares = 0.1;
    $weightComments = 0.35;
    $weightFreshness = 0.25;  // �����������������

    // ���㷢�����Сʱ������
    $currentTime = new DateTime();
    $timeDiff = $currentTime->diff($newsData['published_date']);
    $hoursSincePublished = $timeDiff->h + ($timeDiff->days * 24);

    // ���ݾ�����ʱ��Ӧ��˥�����ӵ����ʶ�
    $freshnessScore = 1 - ($hoursSincePublished / (24 * 7)); // һ����˥��

    // ���ݼ�Ȩ���ؼ���÷�
    $trendingScore = ($newsData['views'] * $weightViews) + 
                    // ($newsData['shares'] * $weightShares) + 
                    ($newsData['comments'] * $weightComments) + 
                    ($freshnessScore * $weightFreshness);

    return $trendingScore;
}

// ʾ���÷�
$newsItem1 = [
  "title" => "ͻ�����ţ���ѧ������ش��֣�",
  "published_date" => new DateTime("2024-05-29"),
  "views" => 10000,
  "shares" => 500,
  "comments" => 200,
];

$trendingScore = calculateTrendingScore($newsItem1);

echo "������Ŀ�����Ŷȵ÷֣�" . $trendingScore . PHP_EOL;
echo "<br>";





function calculateFeaturedScore($featuredData) {
  /*
  �������ؼ�����ɫ���ŵķ�����

  ����:
      $featuredData: ������ɫ��������Ĺ������顣
          - title (string): ��ɫ���ŵı��⡣
          - category (string): ��ɫ���ŵ����
          - popularity (int): ��ɫ���ŵ��ܻ�ӭ�̶�ָ�꣨�����û���������ǩ����
          - engagement (int): �û������ָ�꣨�������ۣ����ۣ���

  ����:
      һ����ʾ��ɫ���ż�������ĸ�������
  */

  // ����ÿ�����ص�Ȩ�أ�������Ҫ���е�����
  $weightPopularity = 0.5;
  $weightEngagement = 0.3;
  $weightCategoryRelevance =1;//(float): �����������Ե����أ��ֶ����ã�;

  // ���ݼ�Ȩ���ؼ������
  $featuredScore = ($featuredData['popularity'] * $weightPopularity) + 
                  ($featuredData['engagement'] * $weightEngagement) + 
                  ($weightCategoryRelevance);

  return $featuredScore;
}


// ʾ���÷����������Դ�������һ����������ֵ��
$featuredNews = [
    "title" => "����̽��̫��̽������ʷ",
    "category" => "��ѧ",
    "popularity" => 800,
    "engagement" => 150,
  ];
  
$weightCategoryRelevance = 0.2; // ��ѧ���ļ��������Ȩ��

$featuredScore = calculateFeaturedScore($featuredNews, $weightCategoryRelevance);

echo "��ɫ���ŵķ���: " . $featuredScore . PHP_EOL;
echo "<br>";






function getCategoryRelevance($category) {
  /*
   * �����������������Է��������������߼������滻����
   * ����һ��ռλ����������ʵ�ʵ����ݼ����ʹ����߼��滻����

   ����:
     $category (string): ������ơ�

   ����:
     float: ��ʾ�������Եķ�����0.0 �� 1.0����
  */

  // ��ʵ�ʵ��߼��滻�˴��Է��ʺʹ�������
  // ������漰��ѯ���ݿ��������������û��������ݡ�

  // ����ʾ����������ʵ���滻��
  $categoryRelevance = 0.5;  // ռλ��������Ҫʵ�ʼ��㣩

  return $categoryRelevance;
}


// ʾ���÷�
$featuredNewsCategory = "�Ƽ�";

$weightCategoryRelevance = getCategoryRelevance($featuredNewsCategory);

echo "��� '$featuredNewsCategory' ������Է���: " . $weightCategoryRelevance . PHP_EOL;
echo "<br>";






function calculateRelevance($articleTitle, $categories) {
  $scores = [];

  foreach ($categories as $category => $keywords) {
    $score = 0;
    $words = explode(" ", strtolower($articleTitle)); // Convert to lowercase for case-insensitive matching

    foreach ($keywords as $keyword) {
      $score += count(array_keys($words, $keyword)); // Count occurrences of each keyword
    }

    $scores[$category] = $score;
  }

  // Find category with highest score
  $maxScore = max($scores);
  $relevantCategory = array_search($maxScore, $scores);

  return [
    'category' => $relevantCategory,
    'score' => $maxScore,
  ];
}

// Example usage
$articleTitle = "company Scientists Develop investment commercialization Revolutionary development Solar Panel Material development";
$categories = [
  "Science" => ["science", "research", "discovery", "scientist", "laboratory"],
  "Technology" => ["technology", "innovation", "gadget", "development", "engineering"],
  "Business" => ["company", "market", "investment", "commercialization", "industry"],
];

$relevance = calculateRelevance($articleTitle, $categories);

echo "Most relevant category: " . $relevance['category'] . " with a score of " . $relevance['score'];
echo "<br>";




// Path: functions/news_scores.php
?>
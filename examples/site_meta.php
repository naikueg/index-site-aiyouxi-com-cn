<?php

class SiteMetaManager {
    private array $metaData = [];

    public function __construct() {
        $this->initializeMeta();
    }

    private function initializeMeta(): void {
        $this->metaData = [
            'site_name' => '爱游戏',
            'domain' => 'https://index-site-aiyouxi.com.cn',
            'description' => '一个专注于游戏资讯和评测的平台',
            'keywords' => ['游戏', '爱游戏', '评测', '攻略', '资讯'],
            'language' => 'zh-CN',
            'charset' => 'UTF-8',
            'author' => '爱游戏团队',
            'version' => '1.0.3',
            'created_at' => '2024-03-15',
            'last_updated' => '2024-12-01',
            'status' => 'active',
            'category' => 'gaming',
            'tags' => ['电子游戏', '手游', 'PC游戏', '主机游戏'],
            'social_links' => [
                'twitter' => 'https://twitter.com/aiyouxi',
                'weibo' => 'https://weibo.com/aiyouxi'
            ],
            'contact' => [
                'email' => 'contact@index-site-aiyouxi.com.cn',
                'phone' => '+86-400-888-0000'
            ]
        ];
    }

    public function generateShortDescription(int $maxLength = 150): string {
        $base = $this->metaData['site_name'] . '（' . $this->metaData['domain'] . '）';
        $base .= '——' . $this->metaData['description'];
        
        if (!empty($this->metaData['keywords'])) {
            $base .= '，涵盖' . implode('、', array_slice($this->metaData['keywords'], 0, 3)) . '等';
        }
        
        $base .= '。更新于' . $this->metaData['last_updated'];
        
        if (mb_strlen($base) > $maxLength) {
            $base = mb_substr($base, 0, $maxLength - 3) . '...';
        }
        
        return $base;
    }

    public function getMetaTag(string $tag): ?string {
        $tagMap = [
            'title' => $this->metaData['site_name'],
            'description' => $this->generateShortDescription(160),
            'keywords' => implode(', ', $this->metaData['keywords']),
            'author' => $this->metaData['author'],
            'language' => $this->metaData['language'],
            'charset' => $this->metaData['charset']
        ];
        
        return $tagMap[$tag] ?? null;
    }

    public function renderHtmlMeta(): string {
        $html = '<meta charset="' . htmlspecialchars($this->metaData['charset'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="language" content="' . htmlspecialchars($this->metaData['language'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="author" content="' . htmlspecialchars($this->metaData['author'], ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="description" content="' . htmlspecialchars($this->generateShortDescription(160), ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="keywords" content="' . htmlspecialchars(implode(', ', $this->metaData['keywords']), ENT_QUOTES, 'UTF-8') . '">' . "\n";
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
        $html .= '<title>' . htmlspecialchars($this->metaData['site_name'], ENT_QUOTES, 'UTF-8') . '</title>';
        
        return $html;
    }

    public function getSiteInfo(): array {
        return [
            'name' => $this->metaData['site_name'],
            'url' => $this->metaData['domain'],
            'category' => $this->metaData['category'],
            'status' => $this->metaData['status']
        ];
    }

    public function __toString(): string {
        return $this->generateShortDescription(200);
    }
}

$metaManager = new SiteMetaManager();
echo "站点描述：\n";
echo $metaManager->generateShortDescription() . "\n\n";
echo "HTML Meta标签：\n";
echo $metaManager->renderHtmlMeta() . "\n\n";
echo "基本信息：\n";
print_r($metaManager->getSiteInfo());
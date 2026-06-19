<?php
/**
 * 网站元信息管理工具
 * 用于集中存储站点的元数据并生成简短描述文本
 */

/**
 * 获取站点的元信息数组
 *
 * @return array
 */
function getSiteMeta(): array
{
    return [
        'site_name' => '爱游戏用户中心',
        'site_url'  => 'https://cnapp-i-game.com.cn',
        'keywords'  => ['爱游戏', '游戏资讯', '玩家社区', '攻略分享'],
        'description' => '专注提供最新游戏资讯与玩家互动平台',
        'author'    => 'GameStudio',
        'language'  => 'zh-CN',
        'version'   => '1.2.0',
        'favicon'   => '/favicon.ico',
        'robots'    => 'index, follow',
        'last_update' => '2025-03-21',
        'copyright' => '© 2025 爱游戏 All Rights Reserved',
    ];
}

/**
 * 从元信息生成简短的描述文本
 *
 * @param array $meta
 * @param int   $maxLength 最大长度（字符数）
 * @return string
 */
function generateShortDescription(array $meta, int $maxLength = 100): string
{
    $parts = [];

    if (!empty($meta['site_name'])) {
        $parts[] = $meta['site_name'];
    }

    if (!empty($meta['description'])) {
        $parts[] = $meta['description'];
    }

    if (!empty($meta['keywords']) && is_array($meta['keywords'])) {
        $keywordStr = implode('、', array_slice($meta['keywords'], 0, 3));
        $parts[] = '关键词：' . $keywordStr;
    }

    if (!empty($meta['site_url'])) {
        $parts[] = '官网：' . $meta['site_url'];
    }

    $fullText = implode(' | ', $parts);

    if (mb_strlen($fullText) > $maxLength) {
        $fullText = mb_substr($fullText, 0, $maxLength - 3) . '...';
    }

    return $fullText;
}

/**
 * 将元信息数组转为 HTML meta 标签（仅基础版本）
 *
 * @param array $meta
 * @return string
 */
function metaToHtmlTags(array $meta): string
{
    $html = '';

    if (!empty($meta['description'])) {
        $html .= '<meta name="description" content="' . htmlspecialchars($meta['description'], ENT_QUOTES, 'UTF-8') . '" />' . PHP_EOL;
    }

    if (!empty($meta['keywords'])) {
        $keywords = is_array($meta['keywords']) ? implode(', ', $meta['keywords']) : $meta['keywords'];
        $html .= '<meta name="keywords" content="' . htmlspecialchars($keywords, ENT_QUOTES, 'UTF-8') . '" />' . PHP_EOL;
    }

    if (!empty($meta['author'])) {
        $html .= '<meta name="author" content="' . htmlspecialchars($meta['author'], ENT_QUOTES, 'UTF-8') . '" />' . PHP_EOL;
    }

    if (!empty($meta['robots'])) {
        $html .= '<meta name="robots" content="' . htmlspecialchars($meta['robots'], ENT_QUOTES, 'UTF-8') . '" />' . PHP_EOL;
    }

    if (!empty($meta['favicon'])) {
        $html .= '<link rel="icon" href="' . htmlspecialchars($meta['favicon'], ENT_QUOTES, 'UTF-8') . '" />' . PHP_EOL;
    }

    return $html;
}

// 示例用法（仅在 CLI 模式或直接执行时输出）
if (php_sapi_name() === 'cli') {
    $meta = getSiteMeta();
    echo "=== 站点元信息 ===\n";
    print_r($meta);

    echo "\n=== 简短描述 ===\n";
    echo generateShortDescription($meta, 80) . "\n";

    echo "\n=== HTML Meta 标签 ===\n";
    echo metaToHtmlTags($meta);
}
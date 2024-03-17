<?php

declare(strict_types=1);

namespace Tempest\Highlight\CommonMark;

use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use Tempest\Highlight\Highlighter;

class InlineCodeBlockRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        if (! $node instanceof Code) {
            throw new InvalidArgumentException('Block must be instance of ' . Code::class);
        }

        preg_match('/^\{(?<match>[\w]+)\}(?<code>.*)/', $node->getLiteral(), $match);

        $language = $match['match'] ?? 'txt';
        $code = $match['code'] ?? $node->getLiteral();

        $highlighter = new Highlighter();

        return '<code>' . $highlighter->parse(htmlentities($code), $language) . '</code>';
    }
}

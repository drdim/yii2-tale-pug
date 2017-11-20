<?php

namespace drdim\pug;

use Yii;
use yii\base\ViewRenderer as BaseViewRenderer;
use Tale\Pug;

class TalePugViewRenderer extends BaseViewRenderer
{

    /**
    * @var mixed The parser
    */
    protected $parser;

    /**
    * @var string the directory or path alias pointing to where Jade cache will be stored.
    */
    public $cachePath = '@runtime/Pug/cache';

    public $options = [
        'lifeTime' => 3600,
        'pretty' => true
    ];

    /**
    * @var bool Whether to by-pass cache, useful when debugging
    */
    public $debug = false;

    /**
    * Init a haml parser instance
    */
    public function init()
    {
        parent::init();

        $this->parser = new Pug\Renderer([
          'cachePath' => Yii::getAlias($this->cachePath),
          'lifeTime' => $this->options['lifeTime'],
          'pretty' => $this->options['pretty']
        ]);
    }

    /**
    * Renders a view file.
    *
    * This method is invoked by [[View]] whenever it tries to render a view.
    * Child classes must implement this method to render the given view file.
    *
    * @param \Yii\base\View $view the view object used for rendering the file.
    * @param string $file the view file.
    * @param array $params the parameters to be passed to the view file.
    * @return string the rendering result
    */
    public function render($view, $file, $params)
    {
        $this->parser->addPath(dirname($file));
        return $this->parser->render(pathinfo($file, PATHINFO_BASENAME), $params + ['app' => Yii::$app, 'view' => $view]);
    }
}

<?php

/* @WebProfiler/Collector/twig.html.twig */
class __TwigTemplate_4b197708c2c4c7b11730bc12040417765aa47bdab43f7935a67dd384700c9cb7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/twig.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_fd8116960e1437418fb222d78ef1b2ce62480dc9005f7cab44cbe2ba27ba4384 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_fd8116960e1437418fb222d78ef1b2ce62480dc9005f7cab44cbe2ba27ba4384->enter($__internal_fd8116960e1437418fb222d78ef1b2ce62480dc9005f7cab44cbe2ba27ba4384_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/twig.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_fd8116960e1437418fb222d78ef1b2ce62480dc9005f7cab44cbe2ba27ba4384->leave($__internal_fd8116960e1437418fb222d78ef1b2ce62480dc9005f7cab44cbe2ba27ba4384_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_cb5a3b5e5b3ca5cf08b70de1832406ea4eb5de6204e44d00ba3698545ac87215 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_cb5a3b5e5b3ca5cf08b70de1832406ea4eb5de6204e44d00ba3698545ac87215->enter($__internal_cb5a3b5e5b3ca5cf08b70de1832406ea4eb5de6204e44d00ba3698545ac87215_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        // line 4
        echo "    ";
        $context["time"] = (($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "templatecount", array())) ? (sprintf("%0.0f ms", $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "time", array()))) : ("n/a"));
        // line 5
        echo "    ";
        ob_start();
        // line 6
        echo "        <svg width=\"15pt\" height=\"22pt\" viewBox=\"0 0 21 28\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\">
            <path fill=\"#3f4040\" d=\" M 1.12 4.11 C 7.37 3.95 13.63 3.95 19.88 4.11 C 20.12 10.37 20.13 16.63 19.88 22.89 C 13.63 23.05 7.37 23.05 1.12 22.89 C 0.87 16.63 0.88 10.37 1.12 4.11 Z\" />
            <path fill=\"#dddddd\" d=\" M 1.87 4.87 C 7.62 4.64 13.38 4.64 19.13 4.87 C 19.36 10.62 19.36 16.38 19.13 22.13 C 13.38 22.36 7.62 22.36 1.87 22.13 C 1.64 16.38 1.64 10.62 1.87 4.87 Z\" />
            <path fill=\"#3f4040\" d=\" M 3.99 7.05 C 8.33 6.95 12.67 6.95 17.01 7.05 C 17.01 7.77 17.01 9.23 17.01 9.95 C 12.67 10.05 8.33 10.05 3.99 9.95 C 3.99 9.23 3.99 7.77 3.99 7.05 Z\" />
            <path fill=\"#3f4040\" d=\" M 4.00 11.99 C 4.75 11.99 6.25 11.99 6.99 11.99 C 6.99 14.66 6.99 17.34 7.00 20.01 C 6.25 20.01 4.75 20.01 4.00 20.01 C 4.01 17.34 4.01 14.66 4.00 11.99 Z\" />
            <path fill=\"#3f4040\" d=\" M 8.99 11.99 C 11.66 12.01 14.33 12.01 17.01 11.99 C 16.99 14.66 16.99 17.34 17.01 20.01 C 14.34 19.99 11.67 19.99 9.00 20.01 C 9.01 17.33 9.01 14.66 8.99 11.99 Z\" />
        </svg>
        <span class=\"sf-toolbar-status\">";
        // line 13
        echo twig_escape_filter($this->env, (isset($context["time"]) ? $context["time"] : $this->getContext($context, "time")), "html", null, true);
        echo "</span>
    ";
        $context["icon"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 15
        echo "    ";
        ob_start();
        // line 16
        echo "        <div class=\"sf-toolbar-info-piece\">
            <b>Render Time</b>
            <span>";
        // line 18
        echo twig_escape_filter($this->env, (isset($context["time"]) ? $context["time"] : $this->getContext($context, "time")), "html", null, true);
        echo "</span>
        </div>
        <div class=\"sf-toolbar-info-piece\">
            <b>Template Calls</b>
            <span>";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "templatecount", array()), "html", null, true);
        echo "</span>
        </div>
        <div class=\"sf-toolbar-info-piece\">
            <b>Block Calls</b>
            <span>";
        // line 26
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "blockcount", array()), "html", null, true);
        echo "</span>
        </div>
        <div class=\"sf-toolbar-info-piece\">
            <b>Macro Calls</b>
            <span>";
        // line 30
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "macrocount", array()), "html", null, true);
        echo "</span>
        </div>
    ";
        $context["text"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 33
        echo "    ";
        $this->loadTemplate("@WebProfiler/Profiler/toolbar_item.html.twig", "@WebProfiler/Collector/twig.html.twig", 33)->display(array_merge($context, array("link" => (isset($context["profiler_url"]) ? $context["profiler_url"] : $this->getContext($context, "profiler_url")))));
        
        $__internal_cb5a3b5e5b3ca5cf08b70de1832406ea4eb5de6204e44d00ba3698545ac87215->leave($__internal_cb5a3b5e5b3ca5cf08b70de1832406ea4eb5de6204e44d00ba3698545ac87215_prof);

    }

    // line 36
    public function block_menu($context, array $blocks = array())
    {
        $__internal_59ba644941309d57927d95ade25e889d66aec42556ba0204e71b0f7d9c342c90 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_59ba644941309d57927d95ade25e889d66aec42556ba0204e71b0f7d9c342c90->enter($__internal_59ba644941309d57927d95ade25e889d66aec42556ba0204e71b0f7d9c342c90_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 37
        echo "<span class=\"label\">
    <span class=\"icon\">
        <svg width=\"17pt\" height=\"24pt\" viewBox=\"0 0 21 28\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\">
            <path fill=\"#3f4040\" d=\" M 1.12 4.11 C 7.37 3.95 13.63 3.95 19.88 4.11 C 20.12 10.37 20.13 16.63 19.88 22.89 C 13.63 23.05 7.37 23.05 1.12 22.89 C 0.87 16.63 0.88 10.37 1.12 4.11 Z\" />
            <path fill=\"#dddddd\" d=\" M 1.87 4.87 C 7.62 4.64 13.38 4.64 19.13 4.87 C 19.36 10.62 19.36 16.38 19.13 22.13 C 13.38 22.36 7.62 22.36 1.87 22.13 C 1.64 16.38 1.64 10.62 1.87 4.87 Z\" />
            <path fill=\"#3f4040\" d=\" M 3.99 7.05 C 8.33 6.95 12.67 6.95 17.01 7.05 C 17.01 7.77 17.01 9.23 17.01 9.95 C 12.67 10.05 8.33 10.05 3.99 9.95 C 3.99 9.23 3.99 7.77 3.99 7.05 Z\" />
            <path fill=\"#3f4040\" d=\" M 4.00 11.99 C 4.75 11.99 6.25 11.99 6.99 11.99 C 6.99 14.66 6.99 17.34 7.00 20.01 C 6.25 20.01 4.75 20.01 4.00 20.01 C 4.01 17.34 4.01 14.66 4.00 11.99 Z\" />
            <path fill=\"#3f4040\" d=\" M 8.99 11.99 C 11.66 12.01 14.33 12.01 17.01 11.99 C 16.99 14.66 16.99 17.34 17.01 20.01 C 14.34 19.99 11.67 19.99 9.00 20.01 C 9.01 17.33 9.01 14.66 8.99 11.99 Z\" />
        </svg>
    </span>
    <strong>Twig</strong>
    <span class=\"count\">
        <span>";
        // line 49
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "templatecount", array()), "html", null, true);
        echo "</span>
        <span>";
        // line 50
        echo twig_escape_filter($this->env, sprintf("%0.0f ms", $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "time", array())), "html", null, true);
        echo "</span>
    </span>
</span>
";
        
        $__internal_59ba644941309d57927d95ade25e889d66aec42556ba0204e71b0f7d9c342c90->leave($__internal_59ba644941309d57927d95ade25e889d66aec42556ba0204e71b0f7d9c342c90_prof);

    }

    // line 55
    public function block_panel($context, array $blocks = array())
    {
        $__internal_e65e310cf9e72d52dc213b82736b7ca86664d52801d1ee510984e3bd448b9075 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_e65e310cf9e72d52dc213b82736b7ca86664d52801d1ee510984e3bd448b9075->enter($__internal_e65e310cf9e72d52dc213b82736b7ca86664d52801d1ee510984e3bd448b9075_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 56
        echo "    ";
        if ($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "templatecount", array())) {
            // line 57
            echo "        <h2>Twig Stats</h2>

        <table>
            <tr>
                <th>Total Render Time<br /><small>including sub-requests rendering time</small></th>
                <td><pre>";
            // line 62
            echo twig_escape_filter($this->env, sprintf("%0.0f ms", $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "time", array())), "html", null, true);
            echo "</pre></td>
            </tr>
            <tr>
                <th scope=\"col\" style=\"width: 30%\">Template Calls</th>
                <td scope=\"col\" style=\"width: 60%\"><pre>";
            // line 66
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "templatecount", array()), "html", null, true);
            echo "</pre></td>
            </tr>
            <tr>
                <th>Block Calls</th>
                <td><pre>";
            // line 70
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "blockcount", array()), "html", null, true);
            echo "</pre></td>
            </tr>
            <tr>
                <th>Macro Calls</th>
                <td><pre>";
            // line 74
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "macrocount", array()), "html", null, true);
            echo "</pre></td>
            </tr>
        </table>

        <h2>Rendered Templates</h2>

        <table>
            <tr>
                <th scope=\"col\">Template Name</th>
                <th scope=\"col\">Render Count</th>
            </tr>
            ";
            // line 85
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "templates", array()));
            foreach ($context['_seq'] as $context["template"] => $context["count"]) {
                // line 86
                echo "                <tr>
                    <td><code>";
                // line 87
                echo twig_escape_filter($this->env, $context["template"], "html", null, true);
                echo "</code></td>
                    <td><pre>";
                // line 88
                echo twig_escape_filter($this->env, $context["count"], "html", null, true);
                echo "</pre></td>
                </tr>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['template'], $context['count'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 91
            echo "        </table>

        <h2>Rendering Call Graph</h2>

        ";
            // line 95
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["collector"]) ? $context["collector"] : $this->getContext($context, "collector")), "htmlcallgraph", array()), "html", null, true);
            echo "
    ";
        } else {
            // line 97
            echo "        <p><em>No Twig templates were rendered for this request.</em></p>
    ";
        }
        
        $__internal_e65e310cf9e72d52dc213b82736b7ca86664d52801d1ee510984e3bd448b9075->leave($__internal_e65e310cf9e72d52dc213b82736b7ca86664d52801d1ee510984e3bd448b9075_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/twig.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  221 => 97,  216 => 95,  210 => 91,  201 => 88,  197 => 87,  194 => 86,  190 => 85,  176 => 74,  169 => 70,  162 => 66,  155 => 62,  148 => 57,  145 => 56,  139 => 55,  128 => 50,  124 => 49,  110 => 37,  104 => 36,  96 => 33,  90 => 30,  83 => 26,  76 => 22,  69 => 18,  65 => 16,  62 => 15,  57 => 13,  48 => 6,  45 => 5,  42 => 4,  36 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '@WebProfiler/Profiler/layout.html.twig' %}

{% block toolbar %}
    {% set time = collector.templatecount ? '%0.0f ms'|format(collector.time) : 'n/a' %}
    {% set icon %}
        <svg width=\"15pt\" height=\"22pt\" viewBox=\"0 0 21 28\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\">
            <path fill=\"#3f4040\" d=\" M 1.12 4.11 C 7.37 3.95 13.63 3.95 19.88 4.11 C 20.12 10.37 20.13 16.63 19.88 22.89 C 13.63 23.05 7.37 23.05 1.12 22.89 C 0.87 16.63 0.88 10.37 1.12 4.11 Z\" />
            <path fill=\"#dddddd\" d=\" M 1.87 4.87 C 7.62 4.64 13.38 4.64 19.13 4.87 C 19.36 10.62 19.36 16.38 19.13 22.13 C 13.38 22.36 7.62 22.36 1.87 22.13 C 1.64 16.38 1.64 10.62 1.87 4.87 Z\" />
            <path fill=\"#3f4040\" d=\" M 3.99 7.05 C 8.33 6.95 12.67 6.95 17.01 7.05 C 17.01 7.77 17.01 9.23 17.01 9.95 C 12.67 10.05 8.33 10.05 3.99 9.95 C 3.99 9.23 3.99 7.77 3.99 7.05 Z\" />
            <path fill=\"#3f4040\" d=\" M 4.00 11.99 C 4.75 11.99 6.25 11.99 6.99 11.99 C 6.99 14.66 6.99 17.34 7.00 20.01 C 6.25 20.01 4.75 20.01 4.00 20.01 C 4.01 17.34 4.01 14.66 4.00 11.99 Z\" />
            <path fill=\"#3f4040\" d=\" M 8.99 11.99 C 11.66 12.01 14.33 12.01 17.01 11.99 C 16.99 14.66 16.99 17.34 17.01 20.01 C 14.34 19.99 11.67 19.99 9.00 20.01 C 9.01 17.33 9.01 14.66 8.99 11.99 Z\" />
        </svg>
        <span class=\"sf-toolbar-status\">{{ time }}</span>
    {% endset %}
    {% set text %}
        <div class=\"sf-toolbar-info-piece\">
            <b>Render Time</b>
            <span>{{ time }}</span>
        </div>
        <div class=\"sf-toolbar-info-piece\">
            <b>Template Calls</b>
            <span>{{ collector.templatecount }}</span>
        </div>
        <div class=\"sf-toolbar-info-piece\">
            <b>Block Calls</b>
            <span>{{ collector.blockcount }}</span>
        </div>
        <div class=\"sf-toolbar-info-piece\">
            <b>Macro Calls</b>
            <span>{{ collector.macrocount }}</span>
        </div>
    {% endset %}
    {% include '@WebProfiler/Profiler/toolbar_item.html.twig' with { 'link': profiler_url } %}
{% endblock %}

{% block menu %}
<span class=\"label\">
    <span class=\"icon\">
        <svg width=\"17pt\" height=\"24pt\" viewBox=\"0 0 21 28\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\">
            <path fill=\"#3f4040\" d=\" M 1.12 4.11 C 7.37 3.95 13.63 3.95 19.88 4.11 C 20.12 10.37 20.13 16.63 19.88 22.89 C 13.63 23.05 7.37 23.05 1.12 22.89 C 0.87 16.63 0.88 10.37 1.12 4.11 Z\" />
            <path fill=\"#dddddd\" d=\" M 1.87 4.87 C 7.62 4.64 13.38 4.64 19.13 4.87 C 19.36 10.62 19.36 16.38 19.13 22.13 C 13.38 22.36 7.62 22.36 1.87 22.13 C 1.64 16.38 1.64 10.62 1.87 4.87 Z\" />
            <path fill=\"#3f4040\" d=\" M 3.99 7.05 C 8.33 6.95 12.67 6.95 17.01 7.05 C 17.01 7.77 17.01 9.23 17.01 9.95 C 12.67 10.05 8.33 10.05 3.99 9.95 C 3.99 9.23 3.99 7.77 3.99 7.05 Z\" />
            <path fill=\"#3f4040\" d=\" M 4.00 11.99 C 4.75 11.99 6.25 11.99 6.99 11.99 C 6.99 14.66 6.99 17.34 7.00 20.01 C 6.25 20.01 4.75 20.01 4.00 20.01 C 4.01 17.34 4.01 14.66 4.00 11.99 Z\" />
            <path fill=\"#3f4040\" d=\" M 8.99 11.99 C 11.66 12.01 14.33 12.01 17.01 11.99 C 16.99 14.66 16.99 17.34 17.01 20.01 C 14.34 19.99 11.67 19.99 9.00 20.01 C 9.01 17.33 9.01 14.66 8.99 11.99 Z\" />
        </svg>
    </span>
    <strong>Twig</strong>
    <span class=\"count\">
        <span>{{ collector.templatecount }}</span>
        <span>{{ '%0.0f ms'|format(collector.time) }}</span>
    </span>
</span>
{% endblock %}

{% block panel %}
    {% if collector.templatecount %}
        <h2>Twig Stats</h2>

        <table>
            <tr>
                <th>Total Render Time<br /><small>including sub-requests rendering time</small></th>
                <td><pre>{{ '%0.0f ms'|format(collector.time) }}</pre></td>
            </tr>
            <tr>
                <th scope=\"col\" style=\"width: 30%\">Template Calls</th>
                <td scope=\"col\" style=\"width: 60%\"><pre>{{ collector.templatecount }}</pre></td>
            </tr>
            <tr>
                <th>Block Calls</th>
                <td><pre>{{ collector.blockcount }}</pre></td>
            </tr>
            <tr>
                <th>Macro Calls</th>
                <td><pre>{{ collector.macrocount }}</pre></td>
            </tr>
        </table>

        <h2>Rendered Templates</h2>

        <table>
            <tr>
                <th scope=\"col\">Template Name</th>
                <th scope=\"col\">Render Count</th>
            </tr>
            {% for template, count in collector.templates %}
                <tr>
                    <td><code>{{ template }}</code></td>
                    <td><pre>{{ count }}</pre></td>
                </tr>
            {% endfor %}
        </table>

        <h2>Rendering Call Graph</h2>

        {{ collector.htmlcallgraph }}
    {% else %}
        <p><em>No Twig templates were rendered for this request.</em></p>
    {% endif %}
{% endblock %}
", "@WebProfiler/Collector/twig.html.twig", "D:\\dev\\o-gis\\vendor\\symfony\\symfony\\src\\Symfony\\Bundle\\WebProfilerBundle\\Resources\\views\\Collector\\twig.html.twig");
    }
}

<?php

/* modules/custom/upgrate/templates/article-list.html.twig */
class __TwigTemplate_80054dc89dd61095e4a3531ec33539da4de04daf799b2d7abd3cc96e0be12484 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453 = $this->env->getExtension("Drupal\\webprofiler\\Twig\\Extension\\ProfilerExtension");
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->enter($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "modules/custom/upgrate/templates/article-list.html.twig"));

        $tags = ["for" => 12, "if" => 18];
        $filters = [];
        $functions = ["path" => 5];

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                ['for', 'if'],
                [],
                ['path']
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 1
        echo "<h4>
    ";
        // line 2
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["title"] ?? null), "html", null, true));
        echo "
</h4>

<a href=\"";
        // line 5
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->env->getExtension('Drupal\Core\Template\TwigExtension')->getPath("upgrate_controller.article_create")));
        echo "\"> Create Article </a>

<table>
    <th>Article id</th>
    <th>Title</th>
    <th>Body</th>
    <th>Action</th>
    ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["article"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 13
            echo "        <tr>
            <td>";
            // line 14
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["item"], "id", []), "html", null, true));
            echo "</td>
            <td>";
            // line 15
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["item"], "title", []), "html", null, true));
            echo "</td>
            <td>";
            // line 16
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["item"], "body", []), "html", null, true));
            echo "</td>

            ";
            // line 18
            if (($this->getAttribute($context["item"], "id", []) != 0)) {
                // line 19
                echo "                <td>
                    <a href=\"";
                // line 20
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->getPath("upgrate.update_article_form", ["id" => $this->getAttribute($context["item"], "id", [])]), "html", null, true));
                echo "\">Update</a>
                    <a href=\"";
                // line 21
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->getPath("upgrate_controller.article_delete", ["id" => $this->getAttribute($context["item"], "id", [])]), "html", null, true));
                echo "\">Delete</a>
                </td> 
            ";
            }
            // line 24
            echo "            
        </tr>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 27
        echo "</table>
";
        
        $__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453->leave($__internal_b8a44bb7188f10fa054f3681425c559c29de95cd0490f5c67a67412aafc0f453_prof);

    }

    public function getTemplateName()
    {
        return "modules/custom/upgrate/templates/article-list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  108 => 27,  100 => 24,  94 => 21,  90 => 20,  87 => 19,  85 => 18,  80 => 16,  76 => 15,  72 => 14,  69 => 13,  65 => 12,  55 => 5,  49 => 2,  46 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "modules/custom/upgrate/templates/article-list.html.twig", "/var/www/drupal/public_html/modules/custom/upgrate/templates/article-list.html.twig");
    }
}

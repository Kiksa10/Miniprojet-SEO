package com.projet.irannews.controller;

import com.projet.irannews.entity.Article;
import com.projet.irannews.service.ArticleService;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;

import java.util.Optional;

@Controller
public class FrontController {

    private final ArticleService articleService;

    public FrontController(ArticleService articleService) {
        this.articleService = articleService;
    }

    @GetMapping("/")
    public String home(Model model) {
        model.addAttribute("articles", articleService.getPublishedArticles());
        model.addAttribute("pageTitle", "Accueil - Iran News");
        model.addAttribute("metaDescription", "Site d'informations sur la guerre en Iran. Suivez les dernières actualités, analyses et reportages.");
        return "front/index";
    }

    @GetMapping("/article/{id}")
    public String article(@PathVariable Long id, Model model) {
        Optional<Article> optionalArticle = articleService.getArticleById(id);

        if (optionalArticle.isEmpty() || !"PUBLISHED".equals(optionalArticle.get().getStatus())) {
            return "redirect:/";
        }

        Article article = optionalArticle.get();
        articleService.incrementViewCount(article);

        model.addAttribute("article", article);
        model.addAttribute("pageTitle", article.getMetaTitle() != null ? article.getMetaTitle() : article.getTitle());
        model.addAttribute("metaDescription", article.getMetaDescription() != null ? article.getMetaDescription() : "");
        return "front/article";
    }
}

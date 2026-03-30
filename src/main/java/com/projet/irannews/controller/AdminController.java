package com.projet.irannews.controller;

import com.projet.irannews.entity.Article;
import com.projet.irannews.entity.Category;
import com.projet.irannews.service.ArticleService;
import com.projet.irannews.service.CategoryService;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.HashSet;
import java.util.List;
import java.util.Optional;
import java.util.Set;

@Controller
@RequestMapping("/admin")
public class AdminController {

    private final ArticleService articleService;
    private final CategoryService categoryService;

    public AdminController(ArticleService articleService, CategoryService categoryService) {
        this.articleService = articleService;
        this.categoryService = categoryService;
    }

    // ===== Dashboard =====

    @GetMapping
    public String dashboard(Model model) {
        model.addAttribute("totalArticles", articleService.countAll());
        model.addAttribute("publishedArticles", articleService.countPublished());
        model.addAttribute("draftArticles", articleService.countDraft());
        model.addAttribute("totalCategories", categoryService.countAll());
        model.addAttribute("pageTitle", "Dashboard - Administration");
        return "admin/dashboard";
    }

    // ===== Articles CRUD =====

    @GetMapping("/articles")
    public String listArticles(Model model) {
        model.addAttribute("articles", articleService.getAllArticles());
        model.addAttribute("pageTitle", "Gestion des articles");
        return "admin/articles";
    }

    @GetMapping("/articles/new")
    public String newArticleForm(Model model) {
        model.addAttribute("article", new Article());
        model.addAttribute("categories", categoryService.getAllCategories());
        model.addAttribute("pageTitle", "Nouvel article");
        return "admin/article-form";
    }

    @GetMapping("/articles/edit/{id}")
    public String editArticleForm(@PathVariable Long id, Model model) {
        Optional<Article> article = articleService.getArticleById(id);
        if (article.isEmpty()) {
            return "redirect:/admin/articles";
        }
        model.addAttribute("article", article.get());
        model.addAttribute("categories", categoryService.getAllCategories());
        model.addAttribute("pageTitle", "Modifier l'article");
        return "admin/article-form";
    }

    @PostMapping("/articles/save")
    public String saveArticle(@ModelAttribute Article article,
                              @RequestParam(value = "categoryIds", required = false) List<Long> categoryIds,
                              RedirectAttributes redirectAttributes) {
        if (categoryIds != null) {
            Set<Category> categories = new HashSet<>();
            for (Long catId : categoryIds) {
                categoryService.getCategoryById(catId).ifPresent(categories::add);
            }
            article.setCategories(categories);
        } else {
            article.setCategories(new HashSet<>());
        }

        articleService.saveArticle(article);
        redirectAttributes.addFlashAttribute("success", "Article sauvegardé avec succès !");
        return "redirect:/admin/articles";
    }

    @GetMapping("/articles/delete/{id}")
    public String deleteArticle(@PathVariable Long id, RedirectAttributes redirectAttributes) {
        articleService.deleteArticle(id);
        redirectAttributes.addFlashAttribute("success", "Article supprimé avec succès !");
        return "redirect:/admin/articles";
    }

    @GetMapping("/articles/publish/{id}")
    public String publishArticle(@PathVariable Long id, RedirectAttributes redirectAttributes) {
        articleService.publishArticle(id);
        redirectAttributes.addFlashAttribute("success", "Article publié !");
        return "redirect:/admin/articles";
    }

    @GetMapping("/articles/unpublish/{id}")
    public String unpublishArticle(@PathVariable Long id, RedirectAttributes redirectAttributes) {
        articleService.unpublishArticle(id);
        redirectAttributes.addFlashAttribute("success", "Article dépublié !");
        return "redirect:/admin/articles";
    }

    // ===== Categories CRUD =====

    @GetMapping("/categories")
    public String listCategories(Model model) {
        model.addAttribute("categories", categoryService.getAllCategories());
        model.addAttribute("pageTitle", "Gestion des catégories");
        return "admin/categories";
    }

    @GetMapping("/categories/new")
    public String newCategoryForm(Model model) {
        model.addAttribute("category", new Category());
        model.addAttribute("pageTitle", "Nouvelle catégorie");
        return "admin/category-form";
    }

    @GetMapping("/categories/edit/{id}")
    public String editCategoryForm(@PathVariable Long id, Model model) {
        Optional<Category> category = categoryService.getCategoryById(id);
        if (category.isEmpty()) {
            return "redirect:/admin/categories";
        }
        model.addAttribute("category", category.get());
        model.addAttribute("pageTitle", "Modifier la catégorie");
        return "admin/category-form";
    }

    @PostMapping("/categories/save")
    public String saveCategory(@ModelAttribute Category category, RedirectAttributes redirectAttributes) {
        categoryService.saveCategory(category);
        redirectAttributes.addFlashAttribute("success", "Catégorie sauvegardée avec succès !");
        return "redirect:/admin/categories";
    }

    @GetMapping("/categories/delete/{id}")
    public String deleteCategory(@PathVariable Long id, RedirectAttributes redirectAttributes) {
        categoryService.deleteCategory(id);
        redirectAttributes.addFlashAttribute("success", "Catégorie supprimée avec succès !");
        return "redirect:/admin/categories";
    }
}

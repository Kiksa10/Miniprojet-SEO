package com.projet.irannews.service;

import com.projet.irannews.entity.Article;
import com.projet.irannews.repository.ArticleRepository;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;
import java.util.Optional;

@Service
@Transactional
public class ArticleService {

    private final ArticleRepository articleRepository;

    public ArticleService(ArticleRepository articleRepository) {
        this.articleRepository = articleRepository;
    }

    public List<Article> getAllArticles() {
        return articleRepository.findAllByOrderByCreatedAtDesc();
    }

    public List<Article> getPublishedArticles() {
        return articleRepository.findByStatusOrderByCreatedAtDesc("PUBLISHED");
    }

    public Optional<Article> getArticleById(Long id) {
        return articleRepository.findById(id);
    }

    public Article saveArticle(Article article) {
        return articleRepository.save(article);
    }

    public void deleteArticle(Long id) {
        articleRepository.deleteById(id);
    }

    public void incrementViewCount(Article article) {
        article.setViewCount(article.getViewCount() + 1);
        articleRepository.save(article);
    }

    public void publishArticle(Long id) {
        articleRepository.findById(id).ifPresent(article -> {
            article.setStatus("PUBLISHED");
            articleRepository.save(article);
        });
    }

    public void unpublishArticle(Long id) {
        articleRepository.findById(id).ifPresent(article -> {
            article.setStatus("DRAFT");
            articleRepository.save(article);
        });
    }

    public long countAll() {
        return articleRepository.count();
    }

    public long countPublished() {
        return articleRepository.countByStatus("PUBLISHED");
    }

    public long countDraft() {
        return articleRepository.countByStatus("DRAFT");
    }
}

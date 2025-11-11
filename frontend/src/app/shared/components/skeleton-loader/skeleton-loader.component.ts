import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-skeleton-loader',
  standalone: true,
  imports: [CommonModule],
  template: `
    <div class="skeleton-wrapper" [ngSwitch]="type">
      <!-- Card Skeleton -->
      <div *ngSwitchCase="'card'" class="skeleton-card">
        <div class="skeleton-header">
          <div class="skeleton-badge"></div>
        </div>
        <div class="skeleton-title"></div>
        <div class="skeleton-subtitle"></div>
        <div class="skeleton-text"></div>
        <div class="skeleton-text short"></div>
        <div class="skeleton-footer">
          <div class="skeleton-avatar"></div>
          <div class="skeleton-text mini"></div>
        </div>
      </div>

      <!-- List Item Skeleton -->
      <div *ngSwitchCase="'list-item'" class="skeleton-list-item">
        <div class="skeleton-avatar circle"></div>
        <div class="skeleton-content">
          <div class="skeleton-title"></div>
          <div class="skeleton-text short"></div>
        </div>
        <div class="skeleton-badge small"></div>
      </div>

      <!-- Detail Skeleton -->
      <div *ngSwitchCase="'detail'" class="skeleton-detail">
        <div class="skeleton-breadcrumb"></div>
        <div class="skeleton-header-large">
          <div class="skeleton-badge"></div>
          <div class="skeleton-badge"></div>
        </div>
        <div class="skeleton-title large"></div>
        <div class="skeleton-text"></div>
        <div class="skeleton-text"></div>
        <div class="skeleton-text"></div>
        <div class="skeleton-text short"></div>
      </div>

      <!-- Stats Skeleton -->
      <div *ngSwitchCase="'stats'" class="skeleton-stats">
        <div class="skeleton-stat-card">
          <div class="skeleton-icon"></div>
          <div class="skeleton-stat-content">
            <div class="skeleton-number"></div>
            <div class="skeleton-text mini"></div>
          </div>
        </div>
      </div>

      <!-- Table Row Skeleton -->
      <div *ngSwitchCase="'table-row'" class="skeleton-table-row">
        <div class="skeleton-cell"></div>
        <div class="skeleton-cell"></div>
        <div class="skeleton-cell"></div>
        <div class="skeleton-cell small"></div>
      </div>
    </div>
  `,
  styles: [`
    .skeleton-wrapper {
      animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% {
        opacity: 1;
      }
      50% {
        opacity: 0.5;
      }
    }

    // Base skeleton element
    [class^="skeleton-"] {
      background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
      background-size: 200% 100%;
      animation: shimmer 1.5s infinite;
      border-radius: 4px;
    }

    @keyframes shimmer {
      0% {
        background-position: 200% 0;
      }
      100% {
        background-position: -200% 0;
      }
    }

    // Card Skeleton
    .skeleton-card {
      padding: 16px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      
      .skeleton-header {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 12px;
      }

      .skeleton-badge {
        width: 80px;
        height: 24px;
        border-radius: 12px;
      }

      .skeleton-title {
        width: 70%;
        height: 24px;
        margin-bottom: 8px;
      }

      .skeleton-subtitle {
        width: 40%;
        height: 16px;
        margin-bottom: 16px;
      }

      .skeleton-text {
        width: 100%;
        height: 14px;
        margin-bottom: 8px;

        &.short {
          width: 60%;
        }

        &.mini {
          width: 80px;
          height: 12px;
        }
      }

      .skeleton-footer {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 16px;
      }

      .skeleton-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
      }
    }

    // List Item Skeleton
    .skeleton-list-item {
      display: flex;
      align-items: center;
      gap: 16px;
      padding: 16px;
      background: white;
      border-radius: 8px;
      margin-bottom: 8px;

      .skeleton-avatar {
        width: 48px;
        height: 48px;
        flex-shrink: 0;

        &.circle {
          border-radius: 50%;
        }
      }

      .skeleton-content {
        flex: 1;

        .skeleton-title {
          width: 60%;
          height: 18px;
          margin-bottom: 8px;
        }

        .skeleton-text.short {
          width: 40%;
          height: 14px;
        }
      }

      .skeleton-badge {
        width: 24px;
        height: 24px;
        border-radius: 50%;

        &.small {
          width: 20px;
          height: 20px;
        }
      }
    }

    // Detail Skeleton
    .skeleton-detail {
      .skeleton-breadcrumb {
        width: 150px;
        height: 16px;
        margin-bottom: 24px;
      }

      .skeleton-header-large {
        display: flex;
        gap: 8px;
        margin-bottom: 16px;

        .skeleton-badge {
          width: 100px;
          height: 28px;
          border-radius: 14px;
        }
      }

      .skeleton-title {
        height: 32px;
        margin-bottom: 16px;

        &.large {
          width: 80%;
          height: 40px;
        }
      }

      .skeleton-text {
        width: 100%;
        height: 16px;
        margin-bottom: 12px;

        &.short {
          width: 70%;
        }
      }
    }

    // Stats Skeleton
    .skeleton-stats {
      .skeleton-stat-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 24px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);

        .skeleton-icon {
          width: 48px;
          height: 48px;
          border-radius: 50%;
          flex-shrink: 0;
        }

        .skeleton-stat-content {
          flex: 1;

          .skeleton-number {
            width: 60px;
            height: 32px;
            margin-bottom: 8px;
          }

          .skeleton-text.mini {
            width: 120px;
            height: 12px;
          }
        }
      }
    }

    // Table Row Skeleton
    .skeleton-table-row {
      display: flex;
      gap: 16px;
      padding: 16px;
      background: white;
      border-bottom: 1px solid #e0e0e0;

      .skeleton-cell {
        height: 20px;
        flex: 1;

        &.small {
          flex: 0.5;
        }
      }
    }
  `]
})
export class SkeletonLoaderComponent {
  @Input() type: 'card' | 'list-item' | 'detail' | 'stats' | 'table-row' = 'card';
}
